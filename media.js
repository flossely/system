function playAudio(obj, name)
{
    obj.src = name;
    obj.play();
}
function pauseAudio(obj)
{
    obj.pause();
}
function playMIDI(id)
{
    MIDIjs.play(id);
}
function pauseMIDI(id)
{
    MIDIjs.pause(id);
}
function playVideo(obj, name)
{
    obj.src = name + "?rev=<?=time();?>";
    obj.play();
}
function pauseVideo(obj)
{
    obj.pause();
}
function mute(x)
{
    if (x != '') {
        x = '';
    } else {
        x = 'true';
    }
    set('sounds', x);
}
