<div class="">
    <div class="container" style="margin-top: 150px;">
        <div class="recovery_content" style="text-align: center;">
            <h3><?=$header?></h3>
            <p style="color: dimgrey; font-size: 16px;"><?=$content?></p>
            <p>Redirecting for 5 seconds...</p>
        </div>
    </div>
</div>
<script>
    setTimeout(function(){
        window.location.href = '<?=$redirect?>';
    }, 5000);
</script>