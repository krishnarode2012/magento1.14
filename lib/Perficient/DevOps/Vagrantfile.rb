Vagrant.configure(2) do |config|
  config.vm.box = 'CentOS-6.6-64-V1'
  if ENV['LOCATION'] != '' && ENV['LOCATION'] != 'NGP' 
    config.vm.box_url = 'http://hub.dcs.perficient.com/vagrant/boxes/CentOS-6.6-64-V1.box'
  else
    config.vm.box_url = '\\\\indianag-filesrv-vm\\Magento\\Vagrant\\Boxes\\CentOS-6.6-64-V1.box'
  end
  config.vm.synced_folder '../../../', '/vagrant', type: 'rsync', rsync__exclude: '.git/'
  config.vm.network 'private_network', ip: '192.168.56.103', netmask: '255.255.0.0'
  
  config.vm.provider 'virtualbox' do |v|
	v.name = 'magento-dev'	
  end
  
  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = 'puppet/manifests'
    puppet.module_path = 'puppet/modules'
    puppet.manifest_file = 'init.pp'
    puppet.facter = {
        "LOCATION" => ENV['LOCATION'] ? ENV['LOCATION'] : 'NGP'
    }
  end
end