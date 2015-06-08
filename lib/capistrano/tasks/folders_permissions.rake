namespace :deploy do
  desc 'Giving folders permissions!'
  task :folders_permissions do
    on roles(:app) do
      within release_path do
        execute :mkdir, "#{release_path}/app/tmp"
        # execute :mkdir, "-p #{release_path}/app/tmp/cache/models"
        # execute :mkdir, "-p #{release_path}/app/tmp/cache/persistent"
        # execute :mkdir, "-p #{release_path}/app/tmp/logs"
        execute :chown, "-R mywallet.www-data #{release_path}/app/tmp"
        execute :chmod, "-R 2775 #{release_path}/app/tmp"
      end
    end
  end
end
