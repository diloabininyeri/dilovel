php-cs-fixer fix . --rules=@PSR1
php-cs-fixer fix . --rules=@PSR2
php-cs-fixer fix . --rules=@PHP71Migration
php-cs-fixer fix . --rules=@PHP73Migration
git add .
git status
git commit -m "$1"
git push