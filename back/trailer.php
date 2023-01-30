<h3>預告片清單</h3>
<div>
    <div style="display: flex; justify-content:content; text-align:center">
        <div style="width: 25%;background-color:#eee;">預告片海報</div>
        <div style="width: 25%;background-color:#eee;">預告片片名</div>
        <div style="width: 25%;background-color:#eee;">預告片排序</div>
        <div style="width: 25%;background-color:#eee;">操作</div>
    </div>
    <form action="./api/edit_trailer.php" method="post">
        <div style="height: 210px;overflow:auto">
            <?php
        $ts = $TRAILER->all(" ORDER BY `rank`");
        foreach ($ts as $key => $t) {
            $prev=($key==0)?$t['id']:$ts[$key]['id']-1;
            $next=($key==(count($ts)-1))?$t['id']:$ts[$key]['id']-1;
        ?>
            <div style="display: flex; justify-content:content; text-align:center">
                <div style="width: 25%;"><img src="./upload/<?= $t['img'] ?>" style="width:100px; margin:0 1px;"></div>
                <div style="width: 25%;"><input type="text" name="" id="" value="<?= $t['name'] ?>"></div>
                <div style="width: 25%;">
                    <input type="button" value="UP" onclick="sw('tarile',<?=$t['id'];?>,<?=$prev;?>)">
                    <input type="button" value="DN" onclick="sw('tarile',<?=$t['id'];?>,<?=$next;?>)">
                </div>
                <div style="width: 25%;">
                    <input type="checkbox" name="sh[]" id="" value="<?= $t['id'] ?>" <?=($t['sh']==1)?'checked':''?>>顯示&nbsp;
                    <input type="checkbox" name="del[]" id=""  value="<?= $t['id'] ?>">刪除&nbsp;
                    <select name="ani[]" id="">
                        <option value="1" <?=($t['ani']==1)?'selected':''?>>淡入淡出</option>
                        <option value="2" <?=($t['ani']==2)?'selected':''?>>滑入滑出</option>
                        <option value="3" <?=($t['ani']==3)?'selected':''?>>縮放</option>
                    </select>
                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <div class="ct">
            <input type="submit" value="編輯確認">
            <input type="reset" value="重置">
        </div>
    </form>
</div>

<hr>
<h3>新增預告片海報</h3>
<form action="./api/add_trailer.php" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>預告片海報<input type="file" name="img" id=""></td>
            <td>預告片片名 <input type="text" name="name"></td>
        </tr>
    </table>
    <div class="ct">
        <input type="submit" value="新增">
        <input type="reset" value="重置">
    </div>
</form>

<script>
    function sw(table,id1,id2) {
        $.post("./api/sw.php",{table,id1,id2},()=>{
            location.reload()
        })
    }
</script>