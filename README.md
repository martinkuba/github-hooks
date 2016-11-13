## github-hooks

Scripts to handle Github webhooks.

### Update local repo

When a push to master occurs, this script does a pull of the local version of the repo to udpate it.

#### Installation

On the server:

* Copy `update-local-repo.php` to Apache www folder (e.g. /var/www/html)
* Ensure that the user under which the script runs has write access to the local repo directory.

If the Github repo is private, setup SSH key.  If running in the default directory with the default wwww-data user:

* sudo mkdir /var/www/.ssh
* sudo chown www-data:www-data /var/www/.ssh
* sudo -Hu www-data ssh-keygen -t rsa # choose "no passphrase"
* sudo cat /var/www/.ssh/id_rsa.pub

Use the public SSH key to create a new deploy key on Github for the repository.

On Github:

* Setup a new webhook to the URL of the `update-local-repo.php` script.

#### Configure

The `$repo_to_path` array is used to map repo names to local paths where local repos reside.  
This way the script can handle multiple repos.  The key of the array is the full name of the Github repository, 
and the value the path to the local repository.

#### Logging

The script writes result of each push event to a log file.  The log file is by default
`update-local-repo.log`.  Again, the user running the script must have write access to this file.
One way to ensure that is to do the following:

* touch update-local-repo.log
* sudo chown www-data update-local-repo.log

