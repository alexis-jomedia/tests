# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.require_version ">= 1.8.1"

Vagrant.configure(2) do |config|

    # Official Ubuntu 16.04
    # config.vm.box = "ubuntu/xenial64"
    config.vm.box = "ubuntu/trusty64"

    config.vm.synced_folder ".", "/vagrant", type: "nfs"


    # VM Config
    config.vm.provider "virtualbox" do |v|
        v.memory = 2048
        v.cpus = 1
    end

    # Network
    config.vm.network "private_network", ip: "192.168.99.99"
    config.vm.network :forwarded_port, host: 8088, guest: 8088, auto_correct: true
    #config.vm.network :forwarded_port, host: 9200, guest: 9200, auto_correct: true
    config.vm.usable_port_range = 8080..9999

    # Provisioning
    config.vm.provision :shell, :path => './vagrant/provision_once.sh'
    config.vm.provision :shell, :path => './vagrant/provision_always.sh', run: "always"

end
