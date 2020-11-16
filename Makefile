.PHONY: qa cs cfx phpstan tests build

qa: cs phpstan

cs:
	vendor/bin/codesniffer app tests

cfx:
	vendor/bin/codefixer app tests

phpstan:
	vendor/bin/phpstan analyse -l max -c phpstan.neon --memory-limit=512M app tests/toolkit

tests:
	vendor/bin/tester -s -p php --colors 1 -C tests

tests-coverage:
	vendor/bin/tester -s -p phpdbg --colors 1 -C --coverage ./coverage.xml --coverage-src ./app tests

#####################
# LOCAL DEVELOPMENT #
#####################

build:
	NETTE_DEBUG=1 bin/console orm:schema-tool:drop --force --full-database
	NETTE_DEBUG=1 bin/console migrations:migrate --no-interaction
	NETTE_DEBUG=1 bin/console doctrine:fixtures:load --no-interaction --append

loc-api:
	NETTE_DEBUG=1 NETTE_ENV=dev php -S 0.0.0.0:8000 www/index.php

loc-api-prod:
	NETTE_ENV=prod php -S 0.0.0.0:8000 www/index.php

loc-adminer: loc-adminer-stop
	docker run -it -d -p 9999:80 --name forest_adminer dockette/adminer:dg

loc-adminer-stop:
	docker stop forest_adminer || true
	docker rm forest_adminer || true
