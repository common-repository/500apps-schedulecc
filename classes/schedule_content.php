<div id="schedule_data" style="display: none;">
    <?php echo esc_html($scheduledata); ?>
</div>
<script>
    /** to create cookie **/
    function schedule_setcookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }
    /** getting token from infinity**/
    function schedule_form() {
        if (schedule_getcookie('token')) {
            //return false;
            var token_value = '';
            setTimeout(() => {
                var schedule_id = document.getElementById('schedule_view');
                schedule_id.contentWindow.postMessage({
                    '500apps': true
                }, '*');
            }, 2000);
            window.addEventListener('message', (event) => {
                token_value = event.data;
                schedule_addtoken(token_value);
                /** extracting token **/
                var base64Url = token_value.split('.')[1];
                var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));
                var jwtresult = JSON.parse(jsonPayload);
                schedule_setcookie('region', jwtresult['env'], 1);
                schedule_setcookie('tenant_id', jwtresult['tenant_id'], 1);
                schedule_setcookie('user_id', jwtresult['user_id'], 1);
                var existing_token = schedule_getcookie('token');
                if (existing_token != token_value) {
                    schedule_setcookie('token', token_value, 1);
                }
            })

        } else {
            setTimeout(() => {
                var schedule_id = document.getElementById('schedule_view');
                schedule_id.contentWindow.postMessage({
                    '500apps': true
                }, '*');
            }, 2000);
            window.addEventListener('message', (event) => {
                schedule_setcookie('token', event.data, 1);
                var token_value = event.data;
                schedule_addtoken(token_value);
                /** extracting token **/
                var base64Url = token_value.split('.')[1];
                var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));
                var jwtresult = JSON.parse(jsonPayload);
                schedule_setcookie('region', jwtresult['env'], 1);
                schedule_setcookie('tenant_id', jwtresult['tenant_id'], 1);
                schedule_setcookie('user_id', jwtresult['user_id'], 1);


            })
        }
    }

    /** adding token value to DB through ajax **/
    function schedule_addtoken(token_value) {
        var token_value = token_value;
        console.log(token_value);
        postData = {
            token_value: token_value,
            action: 'schedule_addtoken'
        };
        jQuery.post(ajaxurl, postData, function(response) {
            setTimeout(function() {
                var response_data = jQuery.trim(response);
                console.log(response_data);
                if (response_data == 'updated0') {
                    //location.reload();
                    console.log('inserted');
                } else {
                    console.log('not inserted');
                }
            }, 2000);
        });
    }
</script>
<?php
include 'other_products.php';
?>