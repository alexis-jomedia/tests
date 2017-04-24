echo "=== Provision_once.sh ==="

# Updating repository
echo "=== Updating repository ==="
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get -y update

sudo apt-get -y install libpcre3

echo "=== Installing Git ==="
sudo apt-get -y install git
# Installing Apache
#echo "=== Installing Apache2 ==="
#sudo apt-get -y install apache2

# nginx
echo "=== Installing nginx ==="
sudo apt-get -y install nginx
sudo service nginx start

# set up nginx server
sudo cp /vagrant/vagrant/nginx.conf /etc/nginx/sites-available/site.conf
sudo chmod 644 /etc/nginx/sites-available/site.conf
sudo unlink /etc/nginx/sites-enabled/site.conf
sudo ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf

# clean /var/www
sudo rm -Rf /var/www

# symlink /var/www => /vagrant
ln -s /vagrant /var/www

# Installing MySQL and it's dependencies, Also, setting up root password for MySQL as it will prompt to enter the password during installation
echo "=== Installing mysql ==="
sudo debconf-set-selections <<< 'mysql-server-5.7 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.7 mysql-server/root_password_again password root'
sudo apt-get -y install mysql-server php7.0-mysql

# Installing PHP and it's dependencies
echo "=== Installing php7 ==="
sudo apt-get -y install php7.0-fpm php7.0-mcrypt php7.0-json php7.0-cli php7.0-curl php7.0-gd php7.0-intl

echo "=== Removing unused packaged ==="
sudo apt-get -y autoremove

echo "=== Restarting nginx ==="
sudo service nginx restart
