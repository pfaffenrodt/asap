ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@:)

.PHONY: help
pwd := $(shell pwd)

#COLORS
GREEN  := $(shell tput -Txterm setaf 2)
WHITE  := $(shell tput -Txterm setaf 7)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

yellowColor :=\x1b[227m
blueColor :=\x1b[39m
cyanColor :=\x1b[36m
defaultColor :=\x1b[m

include .env

##  ,adPPYYba,  ,adPPYba,  ,adPPYYba,  8b,dPPYba,
##  ""     `Y8  I8[    ""  ""     `Y8  88P'    "8a
##  ,adPPPPP88   `"Y8ba,   ,adPPPPP88  88       d8
##  88,    ,88  aa    ]8I  88,    ,88  88b,   ,a8"
##  `"8bbdP"Y8  `"YbbdP"'  `"8bbdP"Y8  88`YbbdP"'
##                                     88
##                                     88

help: ## Show Help
	@echo "\n\n"
	@echo "$$(grep -hE '(^##)' $(MAKEFILE_LIST) | sed -e 's/^\##\s/${cyanColor}/')"
	@echo "${YELLOW}Usage:"
	@echo "\t${RESET}make <target>"
	@echo "\n"
	@echo "$$(grep -hE '(^\S+:.*?##.*$$)' $(MAKEFILE_LIST) | sed -e 's/:.*##\s*/:/' -e 's/^\(.\+\):\(.*\)/${GREEN}\1${RESET}:\2/' | column -c2 -t -s :)"
	@echo "\n"

init: ## init project composer install via composer image
	docker run --rm -v $(pwd):/opt -w /opt laravelsail/php80-composer:latest composer install

up:
	@./vendor/bin/sail up -d
sail: ## forward command to sail.
	./vendor/bin/sail ${ARGS}
sail-docs: ## print sail help and url
	@./vendor/bin/sail help
	@echo "open https://laravel.com/docs/8.x/sail"

assets: ## build assets
	@make -s sail yarn
	@make -s sail yarn dev

watch: ## build assets and watch
	@make -s sail yarn
	@make -s sail yarn watch-poll



# match all unknown tasks
%:
	@:
