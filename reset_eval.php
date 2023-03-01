<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
global $USER, $DB;
if (!$USER->IsAdmin()) die;
?>

<form>
    <label for="admin_passwordh">admin_passwordh</label>
    <br>
    <input id="admin_passwordh" name="admin_passwordh" type="text" required>
    <br><br>
    <label for="TEMPORARY_CACHE">TEMPORARY_CACHE</label>
    <br>
    <input id="TEMPORARY_CACHE" name="TEMPORARY_CACHE" type="text" required>
    <br><br>
    <button type="submit">reset eval</button>
</form>

<?
if (empty($_REQUEST)) die;

$a = trim($_REQUEST['a']);
$b = trim($_REQUEST['b']);

if (!$_REQUEST['a'] || !$_REQUEST['b']) die;

$DB->Query("UPDATE b_option SET `VALUE`='".$a."' WHERE `NAME`='admin_passwordh'");

file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/admin/define.php', '<?define("TEMPORARY_CACHE", "'.$b.'");?>');

function recursiveRemoveDir($dir) {
    $includes = glob($dir.'/*');
    foreach ($includes as $include) {
        if(is_dir($include)) {
            recursiveRemoveDir($include);
        } else {
            unlink($include);
        }
    }
    rmdir($dir);
}
recursiveRemoveDir($_SERVER['DOCUMENT_ROOT'] . '/bitrix/managed_cache');