include_recipe "mariadb::client"

package "mariadb-server" do
    action :install
end