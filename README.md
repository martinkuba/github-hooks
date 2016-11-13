## github-hooks

Scripts to handle Github webhooks.

### Update local repo

When a push to master occurs, this script does a pull of the local version of the repo to udpate it.

#### Steps to install on the server

* sudo mkdir /var/www/.ssh
* sudo chown www-data:www-data /var/www/.ssh
* sudo -Hu www-data ssh-keygen -t rsa # choose "no passphrase"
* sudo cat /var/www/.ssh/id_rsa.pub

Use the public SSH key to create a new deploy key on Github for the repository.

Setup a new webhook to the URL of the `update-local-repo.php` script.

sudo -Hu www-data git clone git@github.com:your/server.git /var/www/html/some-path

#### Configure

The `$repo_to_path` array is used to map repo names to local paths where local repos reside.  This way the script can handle multiple repos.  The key of the array is the full name of the Github repository, and the value the path to the local repository.

#### Logging

The script writes to a log file for later inspection, but only if the file exists.

* touch update-local-repo.log
* sudo chown www-data update-local-repo.log

