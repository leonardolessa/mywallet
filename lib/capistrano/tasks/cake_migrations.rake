namespace :deploy do 
  desc 'Running CakePHP migrations'
  task :cake_migrations do
    on roles(:app) do
      within release_path do
        execute :php, "#{release_path}/app/Console/cake.php -app #{release_path}/app Migrations.migration run all"
      end
    end
  end
end
