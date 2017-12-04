#!/bin/bash

# こっちは複数置ける
forever start samplechat.js
forever start ping.js

# こっちはひとつだけ
# こっちに置くとdocker-compose logs nodeに
# ログが残るので作業するときは入れ替えると良い
node mathbattle.js

