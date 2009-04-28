del .\phpdocs\*.html /s /q
del .\phpdocs\*.css /s /q
phpdoc -t .\phpdocs -o HTML:default:default -d .\  ^> result.txt
move result.txt .\phpdocs
