include_recipe "apt"

# add the MariaDB repo
apt_repository "mariadb" do
  uri "http://mariadb.cu.be//repo/10.0/ubuntu"
  distribution node['lsb']['codename']
  components ["main"]
  keyserver "keyserver.ubuntu.com"
  key "0xcbcb082a1bb943db"
  action :add
end