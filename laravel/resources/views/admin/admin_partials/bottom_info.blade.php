<div class="col-12 mt-5 mb-5 text-center">

    <h3>{{ config('app.name') }} uses
        <a href="https://laravel.com/" title="Laravel Framework" target="_blank">
            Laravel framework
        </a> v{{ Illuminate\Foundation\Application::VERSION }} on
        <a href="https://www.php.net/" title="php" target="_blank">
            PHP
        </a> version {{ PHP_VERSION }}.
        <br />
        Currently on git branch: <?php echo `git branch --show-current`; ?>
    </h3>

    <h3>Currently using {{config('app.env')}} environment, and Debug is set to
        {{config('app.debug') ? 'true': 'false'}}</h3>
    <h3>Using database {{env('DB_DATABASE')}}</h3>
</div>
