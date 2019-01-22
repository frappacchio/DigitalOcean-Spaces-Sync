<div class="dos__loader">
  
</div>

<div class="wrap">

    <h1><?= __('DigitalOcean Spaces Sync Settings', 'dos'); ?></h1>

    <div class="dos__message"></div>

    <p><?= __('Type in your DigitalOcean Spaces container access information.', 'dos'); ?><br/>
        <?= __('Don\'t have an account? <a href="https://goo.gl/SX2UwH">Create it</a>', 'dos'); ?></p>

    <form method="POST" action="options.php">
        <?php settings_fields('dos_settings'); ?>
        <h2><?= __('Connection settings', 'dos'); ?></h2>
        <table class="form-table">

            <tbody>
            <tr>
                <th scope="row"><label for="dos_key"><?= __('DO Spaces Key', 'dos'); ?>:</label></th>
                <td><input id="dos_key" name="dos_key" type="text" class="regular-text code" value="<?= esc_attr( defined( 'DOS_KEY' ) ? DOS_KEY : get_option('dos_key')  ); ?>" <?= ( defined( 'DOS_KEY' ) ? 'disabled' : '' ); ?>/></td>
            </tr>

            <tr>
                <th scope="row"><label for="dos_secret"><?= __('DO Spaces Secret', 'dos'); ?>:</label></th>
                <td><input id="dos_secret" name="dos_secret" type="password" class="regular-text code" value="<?= esc_attr( defined( 'DOS_SECRET' ) ? DOS_SECRET : get_option('dos_secret')  ); ?>" <?= ( defined( 'DOS_SECRET' ) ? 'disabled' : '' ); ?>/></td>
            </tr>

            <tr>
                <th scope="row"><label for="dos_container"><?= __('DO Spaces Container', 'dos'); ?>:</label></th>
                <td><input id="dos_container" name="dos_container" type="text" class="regular-text code" value="<?= esc_attr( defined( 'DOS_CONTAINER' ) ? DOS_CONTAINER : get_option('dos_container')  ); ?>" <?= ( defined( 'DOS_CONTAINER' ) ? 'disabled' : '' ); ?>/></td>
            </tr>

            <tr>
                <th scope="row"><label for="dos_endpoint"><?= __('Endpoint (with scheme)', 'dos'); ?>:</label></th>
                <td>
                    <input id="dos_endpoint" name="dos_endpoint" type="text" class="regular-text code" value="<?= esc_attr( defined( 'DOS_ENDPOINT' ) ? DOS_ENDPOINT : get_option('dos_endpoint')  ); ?>" <?= ( defined( 'DOS_ENDPOINT' ) ? 'disabled' : '' ); ?>/>
                    <p class="description">
                        <?= __('By default', 'dos'); ?>: <code>https://ams3.digitaloceanspaces.com</code>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
        <input type="button" name="test" class="button dos__test__connection" value="<?= __('Check the connection', 'dos'); ?>" />
        <p class="description"><?= __('Save settings before test', 'dos'); ?></p>
        <br/>
        <?php submit_button(__('Save settings','dos'),'primary','submit',false); ?>
        <h2><?= __('File & Path settings', 'dos'); ?></h2>


        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label for="upload_url_path">
                        <?= __('Full URL-path to files', 'dos'); ?>:
                    </label>
                </th>
                <td>
                    <input id="upload_url_path" name="upload_url_path" type="text" class="regular-text code"
                           value="<?= esc_attr( defined( 'UPLOAD_URL_PATH' ) ? UPLOAD_URL_PATH : get_option('upload_url_path')  ); ?>"
                        <?= ( defined( 'UPLOAD_URL_PATH' ) ? 'disabled' : '' ); ?>/>
                    <p class="description">
                        <?= __('Enter storage public domain or subdomain if the files are stored only in the cloud storage', 'dos'); ?>
                        <code>(http://uploads.example.com)</code>,
                        <?= __('or full URL path, if are kept both in cloud and on the server.','dos'); ?>
                        <code>(http://example.com/wp-content/uploads)</code>.
                    <?= __('In that case duplicates are created. If you change one, you change and the other,','dos'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="upload_path">
                        <?= __('Local path', 'dos'); ?>:
                    </label>
                </th>
                <td>
                    <?php
                    $uploadPath = wp_upload_dir();
                    ?>
                    <input id="upload_path" name="upload_path" type="text" class="regular-text code"
                           value="<?= esc_attr( $uploadPath['basedir'] ?$uploadPath['basedir'] : get_option('upload_path')  ); ?>"
                        <?= ( defined( 'UPLOAD_PATH' ) ? 'disabled' : '' ); ?>/>
                    <p class="description">
                        <?= __('Local path to the uploaded files. By default', 'dos'); ?>: <code>wp-content/uploads</code><br/>
                        <?= __('Current installation path is', 'dos'); ?>: <code><?= $uploadPath['basedir']; ?></code><br/>
                        <?= __('Setting duplicates of the same name from the mediafiles settings. Changing one, you change and other', 'dos'); ?>.
                    </p>
                </td>
            </tr>


            <tr>
                <th>
                    <label for="dos_storage_path">
                        <?= __('Storage prefix', 'dos'); ?>:
                    </label>
                </th>
                <td>
                    <input id="dos_storage_path" name="dos_storage_path" type="text" class="regular-text code"
                           value="<?= esc_attr( defined( 'DOS_STORAGE_PATH' ) ? DOS_STORAGE_PATH : get_option('dos_storage_path')  ); ?>"
                        <?= ( defined( 'DOS_STORAGE_PATH' ) ? 'disabled' : '' ); ?>/>
                    <p class="description">
                        <?= __( 'The path to the file in the storage will appear as a prefix / path.', 'dos' ); ?><br/>
                        <?php if(!empty(get_option('dos_storage_path'))): ?>
                            <?= __( 'For example in your case:', 'dos' ); ?>
                            <code><?= get_option('dos_storage_path'); ?></code>
                        <?php endif; ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="dos_filter">
                        <?= __('Filemask/Regex for ignored files', 'dos'); ?>:
                    </label>
                </th>

                <td>
                    <input id="dos_filter" name="dos_filter" type="text" class="regular-text code"
                           value="<?= esc_attr( defined( 'DOS_FILTER' ) ? DOS_FILTER : get_option('dos_filter')  ); ?>"
                        <?= ( defined( 'DOS_FILTER' ) ? 'disabled' : '' ); ?>/>
                    <p class="description">
                        <?= __('By default empty or', 'dos'); ?><code>*</code>
                        <?= __('Will upload all the files by default, you are free to use any Regular Expression to match and ignore the selection you need, for example:', 'dos'); ?>
                        <code>/^.*\.(zip|rar|docx)$/i</code>
                    </p>
                </td>
            </tr>

            </tbody>
        </table>

        <h2><?= __('Sync settings', 'dos'); ?></h2>

        <table class="form-table">
            <tbody>
            <tr>
                <td>
                    <label>
                        <input type="checkbox" name="dos_storage_file_only" value="1" <?= checked( defined( 'DOS_STORAGE_FILE_ONLY' ) ? DOS_STORAGE_FILE_ONLY : get_option('dos_storage_file_only'), 1 ); ?>" <?= ( defined( 'DOS_STORAGE_FILE_ONLY' ) ? 'disabled' : '' ); ?> />
                        <?= __('Store files only in the cloud and delete after successful upload.', 'dos'); ?>
                        <?= __('In that case file will be removed from your server after being uploaded to cloud storage, that saves you space.', 'dos'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <input type="checkbox" name="dos_storage_file_delete" value="1" <?= checked( defined( 'DOS_STORAGE_FILE_DELETE' ) ? DOS_STORAGE_FILE_DELETE : get_option('dos_storage_file_delete'), 1 ); ?>"
                        <?= ( defined( 'DOS_STORAGE_FILE_DELETE' ) ? 'disabled' : '' ); ?> />

                        <?= __( 'Delete file from cloud storage as soon as it was removed from your library.', 'dos' ); ?>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>
        <input type="hidden" name="action" value="update"/>
        <?php submit_button(__('Save settings','dos'),'primary','submit',false); ?>
    </form>
</div>