namespace :deploy do
  desc 'Giving folders permissions!'
  task :folders_permissions do
    on roles(:app) do
      within release_path do
        execute :mkdir, "#{release_path}/app/tmp"
        execute :chown, "-R mywallet.www-data #{release_path}/app/tmp"
        # if wellington see this he'll be shame
        execute :chmod, "-R 777 #{release_path}/app/tmp"
      end
    end
  end
end
