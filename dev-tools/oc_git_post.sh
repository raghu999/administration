#!/bin/bash
# sudo chmod +x oc_git_post.sh
# sudo ./oc_git_post.sh

# prepares the fresh git-owncloud after install config.php with a forcessl
# and two apps direcories

gittargetdir='/var/www/oclg'

# this variable needs to be set because bash will replace a $variable
# with it's contents. if $variable is not defined, it will be set to empty
SERVERROOT='$SERVERROOT'
origin_text=");"
replace_text="
  'forcessl' => true,
  'logtimezone' => 'Europe/Vienna',
  'apps_paths' =>
    array (
      0 =>
       array (
        'path' => OC::$SERVERROOT.'/apps',
        'url' => '/apps',
        'writable' => true,
       ),
      1 =>
       array (
        'path' => OC::$SERVERROOT.'/apps2',
        'url' => '/apps2',
        'writable' => false,
       )
      ),
);"

# we need to escape the replacement string due to special characters
escaped_var=$(printf '%s\n' "$replace_text" | sed 's:[/&\]:\\&:g;s/$/\\/')
escaped_var=${escaped_var%?}
#echo $escaped_var
sed -i "s/$origin_text/$escaped_var/g" $gittargetdir/config/config.php
