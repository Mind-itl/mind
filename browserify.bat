@echo off
("./node_modules/.bin/babel" js --out-dir compiled-js) && ("./node_modules/.bin/browserify" compiled-js/src/%1 -o public_html/js_pages/%1)
