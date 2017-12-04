#!/usr/bin/env python
# -*- coding: utf-8 -*-

import mysql.connector
import re
import os
from pprint import pprint
from pprint import pformat
import configparser

#http://stackoverflow.com/questions/4408714/execute-sql-file-with-python-mysqldb
def import_sql_file(cursor, sql_file):
	statement = ""

	for line in open(sql_file):
		if re.match(r'--', line):  # ignore sql comment lines
			continue
		if not re.search(r'[^-;]+;', line):  # keep appending lines that don't end in ';'
			statement = statement + line
		else:  # when you get a line ending in ';' then exec statement and reset for next statement
			statement = statement + line
			#print "\n\n[DEBUG] Executing SQL statement:\n%s" % (statement)
			try:
				cursor.execute(statement)
			except (OperationalError, ProgrammingError) as e:
				print ("\n[WARN] MySQLError during execute statement \n\tArgs: '%s'" % (str(e.args)))

			statement = ""

def dump_tables(cursor):
	cursor.execute('show tables')
	raw_table_list = cursor.fetchall()
	table_list = []
	for table in raw_table_list:
		table_list.append(table[0])
	return table_list

def get_ini_sql_section_by_dict(filename):
	file = configparser.SafeConfigParser()
	file.read(filename)
	items_list = file.items('sql')
	config = {}
	for item in items_list:
		config[item[0]] = item[1]
	return config

if __name__ == '__main__':
	print('init db')

	# get config value

	config_sql_default = get_ini_sql_section_by_dict('config/default_config.ini')
	config_sql_user = get_ini_sql_section_by_dict('config/user_config.ini')

	config_sql = config_sql_default
	for key,value in config_sql_user.items():
		config_sql[key] = value

	# connect db
	db = mysql.connector.connect(user=config_sql['username'],password=config_sql['password'],host=config_sql['host'],database=config_sql['dbname'],charset='utf8')

	# たぶん無効にできてない
	db.autocommit = False
	cursor = db.cursor(buffered=True)
	old_table_list = []
	new_table_list = []

	try:
		# 既に存在するテーブルをtempにする
		old_table_list = dump_tables(cursor)
		for table in old_table_list:
			cursor.execute('ALTER TABLE %s RENAME TO %s' % (table, 'temp_'+table))

		# sqlファイルから新しいテーブルを適用する
		new_table_list = []
		sql_files_name = os.listdir('sql/')
		for sql_file_name in sql_files_name:
			sql_file_name = 'sql/' + sql_file_name
			import_sql_file(cursor, sql_file_name)
			all_tables = dump_tables(cursor)
			for table in all_tables:
				if not 'temp_' in table:
					if not table in new_table_list:
						new_table_list.append(table)

		# 古いテーブルのデータを新しいテーブルに移行する
		for table in old_table_list:
			if table in new_table_list:
				# 現在のテーブルのフィールド一覧を取得
				cursor.execute('show columns from %s' % ('temp_'+table))
				columns_list = cursor.fetchall()
				field_list = []
				for column in columns_list:
					field_list.append(column[0])
				# duplicate, export all column
				try:
					field_list_str = ','.join(field_list)
					cursor.execute('insert into %s(%s) select * from %s' % (table, field_list_str, 'temp_'+table))
				except mysql.connector.errors.IntegrityError as e:
					if e.args[0] == 1062:
						# 重複エラーなら無視
						pass
					else:
						raise e
				cursor.execute('DROP TABLE %s' % 'temp_'+table)
			else:
				# unique, undo rename temp table.
				print('unique : '+table)
				cursor.execute('ALTER TABLE %s RENAME TO %s' % ('temp_'+table, table))

		# show result
		dump_tables(cursor)

		db.commit()

	except Exception as e:
		db.rollback()
		raise e

	finally:
		cursor.close()
		db.close()
