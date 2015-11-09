# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  config.vm.box = "ubuntu/trusty64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  config.vm.box_check_update = false

  config.vm.network "forwarded_port", guest: 80, host: 80
  config.vm.network "forwarded_port", guest: 8080, host: 8080
  config.vm.network "forwarded_port", guest: 1080, host: 1080

  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end

  config.vm.provision "shell", inline: <<-SHELL
    #sudo apt-get update

    export DEBIAN_FRONTEND=noninteractive

    export LANGUAGE=en_US.UTF-8
    export LANG=en_US.UTF-8
    export LC_ALL=en_US.UTF-8
    sudo locale-gen en_US.UTF-8
    sudo dpkg-reconfigure locales

    echo mysql-server mysql-server/root_password password superKwel | sudo debconf-set-selections
    echo mysql-server mysql-server/root_password_again password superKwel | sudo debconf-set-selections
    sudo apt-get install -y nginx mysql-server ruby-dev mongodb libsqlite3-dev g++ \
        sshpass php5-{cli,intl,mysql,sqlite,fpm,mongo} git

    sudo cp /vagrant/conf/nginxPhpFpm.conf /etc/nginx/sites-enabled/default

    sudo /etc/init.d/nginx restart

    if [ ! -f /usr/local/bin/composer ] ; then
        echo "Installing Composer"
        sudo wget --quiet https://getcomposer.org/composer.phar -O /usr/local/bin/composer
        sudo chmod +x /usr/local/bin/composer
    else
        echo "Composer already installed"
    fi

    if [ ! -f /usr/local/bin/symfony ] ; then
        echo "Installing Symfony"
        sudo wget --quiet http://symfony.com/installer -O /usr/local/bin/symfony
        sudo chmod a+x /usr/local/bin/symfony
    else
        echo "Symfony already installed"
    fi

    if hash mailcatcher 2>/dev/null; then
        echo "Mail catcher already installed"
    else
        echo "Installing Mailcatcher"
        sudo gem install --no-rdoc --no-ri mailcatcher
    fi

    sudo mkdir /srv/www -p
    sudo chown -R vagrant.vagrant /srv/www

    echo "copying files from share into guest"
    rsync -r --exclude vendors --exclude bin /vagrant/ /srv/www/

    if [ -f /srv/www/composer.lock ] ; then
        cd /srv/www
        /usr/local/bin/composer install
        cd -
    else
        echo "ERROR: Composer lock file not found!"
    fi

    sudo chown -R www-data.www-data /srv/www/app/{cache,logs}/
    sudo chmod -R +rw /srv/www/app/{cache,logs}/
  SHELL
end
