@servers(['production' => 'jrichhart@45.55.93.188', ['localhost' => '127.0.0.1']])

@setup
$projectDomain = 'https://linky.doubleoh13.dev';
$repository = 'https://github.com/jrichhart/linky.git';
$baseDir = '/var/www/linky';
$branch = 'master';
$artisan = "sudo -u linky /usr/bin/php $baseDir/artisan";
@endsetup

@story('deploy')
bring-down
update-code
install-dependencies
build-assets
run-migrations
optimize
restart-horizon
bring-up
@endstory

@task('clone', ['on' => 'production'])
if [ -d {{ $baseDir }} ]; then
echo "Cloning repository..."
git clone {{ $repository }} {{ $baseDir }}
else
echo "Repository already exists, skipping..."
fi
@endtask

@task('bring-down', ['on' => 'production'])
echo "Putting application into maintenance mode..."
{{$artisan}} down
@endtask

@task('bring-up', ['on' => 'production'])
echo "Bringing out of maintenance mode..."
{{$artisan}} up
@endtask

@task('update-code', ['on' => 'production'])
echo "Starting deployment"
cd {{ $baseDir }}
echo "Resetting Git repository..."
git reset --hard
echo "Pulling latest changes from Git..."
git pull origin {{ $branch }}
@endtask

@task('install-dependencies', ['on' => 'production'])
echo "Installing/updating Composer dependencies..."
cd {{ $baseDir }}
composer install --no-dev --optimize-autoloader
@endtask

@task('run-migrations', ['on' => 'production'])
echo "Running migrations..."
cd {{ $baseDir }}
{{ $artisan }} migrate --force
@endtask

@task('optimize', ['on' => 'production'])
echo "Optimizing Laravel..."
cd {{ $baseDir }}
{{ $artisan }} optimize
@endtask

@task('restart-horizon', ['on' => 'production'])
echo "Restarting Horizon..."
cd {{ $baseDir }}
{{ $artisan }} horizon:terminate
@endtask

@task('build-assets', ['on' => 'production'])
echo "Rebuilding assets..."
cd {{ $baseDir }}
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

nvm use default

rm -rf {{ $baseDir }}/node_modules
npm ci
npm run build
rm -rf {{ $baseDir }}/node_modules
@endtask

@task('health-check')
echo "Performing health check..."
curl -fs {{ $projectDomain }}/up > /dev/null || (echo "Health check failed!" && exit 1)
echo "Health check passed!"
@endtask

@success
echo "Deployment complete!";
@endsuccess
