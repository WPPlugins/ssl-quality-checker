
<div class="wrap">
    <h2>SSL Quality Test Results</h2>
    <table class="ssl-status-summary">
        <tr class="first">
            <th>Time Run:</th>
            <td>
                <?php echo date("d / m / Y @ H:i" , $response->startTime / 1000); ?>
            </td>
        </tr>
        <tr>
            <th><label for="textbox">Endpoints:</label></th>
            <td class="endpoints">
                <?php echo count( $response->endpoints) > 0 ? count( $response->endpoints) : ''; ?>
            </td>
        </tr>
    </table>
    <div class="loading"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/'?>ajax-loader.gif"></div>
    <table class="ssl-status-details" style="display: none;">
        <tr>
            <th class="grade_col">Grade</th>
            <th class="ipaddress_col">IP Address</th>
            <th class="status_col">Status</th>
            <th class="progress_col">Progress</th>
            <th></th>
        </tr>
    </table>
    <div style="max-width: 600px;float: left">
        <p></p><a href="<?php echo esc_url($refresh_url) ?>">Check SSL now</a></p>
        <p>Scan provided by <a target="_blank" href="https://www.ssllabs.com/index.html">Qualys SSL Labs</a> <br><a target="_blank" href="https://www.ssllabs.com/downloads/Qualys_SSL_Labs_Terms_of_Use.pdf">Terms and Conditions</a></p>

    </div>
    <div class="logo createful">
        <p>Plugin by</p>
        <a target="_blank" href="https://www.createful.com"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="270px" height="94px" viewBox="0 0 270 93.8" enable-background="new 0 0 270 93.8" xml:space="preserve" class="logo logo-full"><path d="M257.5 47.6c0.2-0.8 0.3-1.4 0.3-2c5.1-8.4 12.2-22.1 12.2-34.1c0-8.5-2.7-11-6.1-11 c-10.2 0-15.2 32.7-15.2 47.9c0 2.6 0.2 5.1 0.5 7.5c-1.9 2.6-3.9 4.5-5.9 4.5c-2.4 0-3.9-5.3-3.9-14.7v-1.1 c2.1-3.7 3.2-7.3 3.2-10.1s-1.4-4.5-3.7-4.5c-4.2 0-7.4 7-7.8 18.6c-2.5 5.8-6.4 11.6-8.8 11.6c-1.6 0-2.9-1.5-2.9-6.9 c0-2.3 0.4-5.1 0.8-7.6c1.9-3.7 2.9-7.4 2.9-10.1c0-2.3-0.7-3.8-2.2-3.8c-3.9 0-6.4 5.1-8 11.2c-0.3 1.2-0.6 2.8-0.8 4.4 c-1.7 1-3.9 1.7-6.5 1.7c-0.8 0-1.5 0-2.3-0.1c-1-2-2.2-3.7-3.3-5.2c5.3-8.3 11.6-20.6 11.6-31.6c0-8.5-2.8-11-6.2-11 c-8.7 0-12.5 18.6-14.8 37.1c-1.9 0.7-3.2 2.3-3.2 4.8c0 1.9 0.8 3.6 2 5c0 0.3-0.1 0.6-0.1 0.8c-3 4.7-8.1 10.6-14.5 10.6 c-3.7 0-5.4-2.3-5.9-5.6c8.2-1.1 17-7.9 17-14.9c0-4-3-7.1-7.1-7.1c-7.9 0-17.3 11.1-17.6 22.1c-2 2.5-4.4 4.4-6.9 4.4 c-2.6 0-4.2-2.3-4.2-7.6c0-3.5 1.3-9.3 2.5-15.2c13.2-0.8 19.8-4.8 19.8-8.5c0-3.4-3.2-5.3-3.2-5.3s-4.2 6.1-15.4 8 c0.7-3.5 1.2-6.7 1.2-9.1c0-4.8-6.4-4.8-8.6-4.8c0.5 2 0.7 4.1 0.7 6.2c0 2.7-0.4 5.4-0.8 8.2c-2.3-0.3-5.3-0.9-5.3-0.9 s-1.1 2-1.1 4.3c0 1 1.5 1.8 5.4 2.1c-1 4.1-2.1 8-2.9 11.5c-2.4 4.2-5.9 9.1-9.2 9.1c-0.8 0-1.8-1.1-2.1-5.4 c3.1-6.1 5.2-12.2 5.2-15.5c0-3.7-1.6-5.1-3.1-5.1c-1.4 0-2.7 1.4-3.9 3.5c-1.2-1.3-3-2.1-5.6-2.1c-6.6 0-14.7 8.5-16.3 19.3 c-3.2 4.8-7.8 9.6-12.9 9.6c-3.6 0-5.4-2.3-6-6.6c7.3-1.5 16.4-7.4 16.4-15.9c0-4.5-2.6-7-6.6-7c-8.5 0-18.1 11.2-18.1 24 c0 7.1 3 13 10.3 13c6.7 0 12.6-4.9 16.8-10.4c0.9 4.5 4 7.7 8.1 7.7c4.1 0 7.1-2.2 9.4-5.4c0.9 1.7 2.5 3.4 5.4 3.4 c3.8 0 8.1-3.9 11.4-8.2c0.4 7.6 4.7 11 9.3 11c3.9 0 7.9-3 11.3-6.8c1.3 4 4.2 7 9.5 7c7 0 13.3-5.3 17.3-10.5 c-0.4 5.6-0.7 10.6-0.7 15c0 14.8 2.6 22.6 8.5 22.6c10.4 0 11.7-19.1 11.7-24.5c0-5.8-1-11-2.6-15.2c2.3-0.2 4.3-0.6 6.1-1.4 c-0.1 1.4-0.1 2.8-0.1 4.3c0 6.7 2.8 10.2 7.8 10.2s8.8-4.3 12-10c0.8 7.6 3.6 11.9 8.7 11.9c3.6 0 7.2-3.1 10.2-7.1 c1.8 6.4 4.8 10.6 8.1 10.6c5.6 0 8.3-7.9 8.3-8.8C262.2 63.3 258.3 57.7 257.5 47.6z M95 38c1.6 0 2.7 1.2 2.7 3.2 c0 3.5-3.6 6.9-9.6 9C88.4 42.5 91.9 38 95 38z M123.8 53.6c-1.6 2.3-3.7 3.5-5.4 3.5c-2 0-3.7-2.5-3.7-7c0-7.3 3.6-11.6 6.4-11.6 c2.1 0 3.9 1.4 4.7 4.4C124.9 46.4 124.2 50.3 123.8 53.6z M176.5 37.7c1.2 0 1.9 0.9 1.9 2.5c0 3.2-2.6 8.3-9.5 10 C169.5 43.8 173.5 37.7 176.5 37.7z M205.7 12.4c0.9 0 1 2 1 3.6c0 7.8-4.3 16.6-8.1 22.7C200.9 23.5 204.1 12.4 205.7 12.4z M200.2 78.8c-2.6 0-3.6-5.1-3.6-11.4c0-4.9 0.2-9.9 0.6-14.7c1.2 0.5 2.4 0.8 3.7 0.9c1.4 3.7 2.6 8.3 2.6 13.4 C203.5 72.4 202.6 78.8 200.2 78.8z M264 11.6c1 0 1.1 2.1 1.1 3.6c0 7.9-4.1 17-7.6 23.3C258.4 26.4 261.7 11.6 264 11.6z"></path><path d="M82.4 39.9c0-4.1-1.8-10-6.2-10c-4.5 0-8.5 3.9-11.9 9c0-0.5 0.1-0.8 0.1-1.3c0-5.4-9.1-5.9-9.1-5.9 c0.7 2.7 0.8 5.4 0.8 8.1c0 1.4-0.1 2.7-0.2 4.1C52.6 49.8 42.7 64.8 28 64.8c-10 0-15.8-6.9-15.8-21.5c0-20.9 11.9-38.2 24.3-38.2 c4.9 0 7.6 2.7 7.6 6.1c0 3.3-2.6 5.7-7 5.7c-3.5 0-4.9-1.6-4.9-1.6s-1.1 0.8-1.1 2.9c0 3.8 3.7 5.9 8.7 5.9 c7.7 0 13.5-4.9 13.5-11.8C53.5 5.5 48 0 37.8 0C16.5 0 0 24.1 0 46.2c0 17.4 10.2 27.4 24.2 27.4c14.4 0 24.7-10.6 30.2-19.1 c-0.6 3.5-1.1 6.7-1.1 9.5c0 3 1.4 4 3.1 4c2.8 0 6.7-2.7 6.7-2.7c-0.6-1.9-0.8-4-0.8-6.4c0-11.6 6.3-21.9 9.8-21.9 c1.3 0 2.4 1.6 2.4 9C79.3 46.1 82.4 43.2 82.4 39.9z"></path></svg></a>
    </div>
</div>
<?php
    $nonce = wp_create_nonce("ssl_check_status");
    $url = admin_url('admin-ajax.php?action=ssl_check_status&nonce=' . $nonce);
    $done_url = admin_url('admin.php?page=ssl-labs-view-status');
    $poll_interval = 5000;
?>
<script>
jQuery(document).ready(function($) {

    var createDetailRow = function(endpoint){
        if(endpoint.grade){
            return $('<tr class="detailrow"> <td><div class="grade grade-' + endpoint.grade.substring(0,1).toLowerCase() +'">' + endpoint.grade + '</div></td><td>' + endpoint.ipAddress + '</td><td>' + (endpoint.statusDetailsMessage ? endpoint.statusDetailsMessage : '') + '</td> <td></td><td></tr>');
        }else{
            return $('<tr class="detailrow"> <td><div class="grade grade-unknown">?</div></td> <td>' + endpoint.ipAddress + '</td> <td>' + (endpoint.statusDetailsMessage ? endpoint.statusDetailsMessage : '') + '</td> <td>' + (endpoint.progress > 0 ? endpoint.progress : 0) + '% </td><td><img class="loader" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/'?>ajax-loader.gif"></td></tr>');
        }

    }
    var checkstatus = function(){
        $.ajax({
            type: "get",
            dataType: "json",
            url: '<?php echo $url ?>',
            data: {action: "ssl_check_status", nonce: '<?php echo $nonce ?>'},
            success: function (response) {
                console.log(response);
                var endpoints = response.endpoints;
                if(endpoints) {
                    $('.ssl-status-details').show();
                    $('.loading').hide();
                    $('.endpoints').html(endpoints.length)
                    $('.detailrow').remove();
                    for (var x = 0; x < endpoints.length; x++) {
                        var element = createDetailRow(endpoints[x]);
                        $('.ssl-status-details').append(element);
                    }
                }
                if(response.status == "IN_PROGRESS"){
                    setTimeout(checkstatus, <?php echo $poll_interval * 2 ?>);
                }else{
                    window.location.replace("<?php echo $done_url ?>");
                }
            }
        });
    }
    setTimeout(checkstatus, <?php echo $poll_interval ?>);


});

</script>