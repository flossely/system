<?php include 'syspkg.php'; ?>
<select id="enterKey" onchange="
var curSys = '<?=$syspkg['name'];?>';
var keyVal = enterKey.options[enterKey.selectedIndex].value;
if (keyVal == 'i') {
    enterPkg.value = 'from';
    enterRepo.value = '';
    enterBranch.value = '';
    enterUser.value = '';
} else if (keyVal == 'r') {
    enterPkg.value = curSys;
    enterRepo.value = '';
    enterBranch.value = '';
    enterUser.value = '';
} else if (keyVal == 'd') {
    enterPkg.value = '';
    enterRepo.value = 'from';
    enterBranch.value = '';
    enterUser.value = 'here';
}">
<option value='i'>Install</option>
<option value='r'>Replace</option>
<option value='d'>Remove</option>
</select>
<select id="enterHost">
<option value="https://github.com">GitHub</option>
<option value="https://gitlab.com">GitLab</option>
<option value="https://bitbucket.org">BitBucket</option>
</select>
<input type="text" id="enterPkg" style="width:12%;" placeholder="Package" value="from">
<input type="text" id="enterRepo" style="width:12%;" placeholder="Repo" value="">
<input type="text" id="enterBranch" style="width:12%;" placeholder="Branch" value="">
<input type="text" id="enterUser" style="width:12%;" placeholder="User" value="">
<input id='getButton' type="button" class="actionButton" onmouseover="playAudio(soundPlayer, '<?=$soundlib[rand(0,$soundct)];?>?rev=<?=time();?>');" onclick="get(enterKey.options[enterKey.selectedIndex].value,enterHost.options[enterHost.selectedIndex].value,enterPkg.value,enterRepo.value,enterBranch.value,enterUser.value,false);" value=">">
<input id='getButton' type="button" class="actionButton" onmouseover="playAudio(soundPlayer, '<?=$soundlib[rand(0,$soundct)];?>?rev=<?=time();?>');" onclick="window.location.href = 'index.php';" value="X">
