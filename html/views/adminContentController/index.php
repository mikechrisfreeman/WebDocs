<div id="adminContent" class="container">
    <h1>Website Deployment Administration Section</h1>

    <h2>Install Plugin</h2>

    <!--Install Plugin section -->
    <div id="installPlugins" class="row">
        <div class="col-md-4">
            <label for="uninstalledPlugins">Uninstalled Plugins</label>
            <select id="uninstalledPlugins">
                <?php foreach($this->model->uninstalledPlugins as $plugin): ?>
                    <option value="<?php echo $plugin->id; ?>">
                    <?php echo $plugin->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
        <button type="button" id="installPlugin">Install Selected Plugin</button>
        </div>
        <div class="col-md-2">
            <button type="button" id="scanPlugins">Scan Plugins</button>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2" >
            <div id="installOutcome"></div>
        </div>
    </div>

    <!--enable plugin section - contains a hidden form-->
    <h2>Enable Plugin</h2>
    <div id="enablePlugins" class="row">
        <form role="form">
            <div class="col-md-4">
                <label for="installedPlugins">Installed Plugins</label>
                <select id="installedPlugins">
                    <?php foreach($this->model->installedPlugins as $plugin): ?>
                        <option value="<?php echo $plugin->id; ?>">
                        <?php echo $plugin->name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                        <div class="form-group">
                            <label for="controllers">Controllers</label>
                            <select id="controllers"></select>
                        </div>
            </div>
            <div class="col-md-2">
                        <div class="form-group">
                            <label for="pages">Page</label>
                            <select id="pages"></select>
                        </div>
            </div>
            <div class="col-md-2">
                    <button type="button" id="enablePlugin">Install Selected Plugin</button>
            </div>
        </form>
            <div class="col-md-2">
                <div id="enableOutcome"></div>
            </div>
    </div>

    <!--enabled Plugins section -->
    <h2>Enabled Plugins</h2>
    <div id="enabledPluginsTable">
        <table class="table">
            <thead>
            <tr>
                <th>Plugin Name</th>
                <th>Controller Name</th>
                <th>PageName</th>
                <th>Disable</th>
                <th>success</th>
            </tr>
            </thead>
            <tbody>
            <?php $id = 0; ?>
            <?php foreach($this->model->enabledPlugins as $enabled): ?>
                <tr>
                    <form id="<?php echo $id; ?>">
                        <td>
                            <input id="<?php echo $id; ?>plugin" type="hidden" class="plugin" value="<?php echo $enabled->plugin->id; ?>" />
                            <?php echo $enabled->plugin->name; ?>
                        </td>
                        <td>
                            <input id="<?php echo $id; ?>controller" type="hidden" class="controller" value="<?php echo $enabled->controller->id; ?>" />
                            <?php echo $enabled->controller->name; ?>
                        </td>
                        <td>
                            <input  id="<?php echo $id; ?>page" type="hidden" class="page" value="<?php echo $enabled->page->id; ?>" />
                            <?php echo $enabled->page->name; ?>
                        </td>
                        <td>
                            <button type="button" onclick="disablePlugin('<?php echo $id; ?>')">Disable</button>
                        </td>
                        <td>
                            <div id="success<?php echo $id;?>"></div>
                        </td>
                    </form>
                </tr>
            <?php $id = $id + 1; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!--end enable plugin section-->
</div>