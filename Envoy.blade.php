@servers(['production' => ['production']])

@setup
    $repo = 'https://github.com/rizkikurni/e-voting-new.git';
    $appDir = '/var/www/e-voting';
    $branch = 'danu';

    date_default_timezone_set('Asia/Jakarta');
    $date = date('YmdHis');

    $builds = $appDir . '/sources';
    $deployment = $builds . '/' . $date;

    $serve = $appDir . '/source';
    $env = $appDir . '/.env';
    $storage = $appDir . '/storage';
@endsetup

@story('deploy')
    git
    install
    live
@endstory

@task('git', ['on' => 'production'])
    git clone -b {{ $branch }} "{{ $repo }}" {{ $deployment }}
@endtask

@task('install', ['on' => 'production'])
    cd {{ $deployment }}

    rm -rf {{ $deployment }}/storage

    ln -nfs {{ $env }} {{ $deployment }}/.env

    ln -nfs {{ $storage }} {{ $deployment }}/storage

    composer install --prefer-dist --no-dev

    php ./artisan storage:link

    echo "🚀 Running Migrations..."
    php ./artisan migrate --force || { echo "❌ Migration failed"; exit 1; }

    echo "🚀 Running Seeder..."
    php ./artisan db:seed --class=UsersSeeder --force||{ echo "❌ Seeding failed"; exit 1; }
    php ./artisan db:seed --class=SubscriptionPlanSeeder --force||{ echo "❌ Seeding failed "; exit 1; }
@endtask

@task('live', ['on' => 'production'])
    cd {{ $deployment }}

    ln -nfs {{ $deployment }} {{ $serve }}


    sudo chown -R www-data: /var/www
    sudo systemctl restart php8.3-fpm
    sudo systemctl restart nginx
@endtask
