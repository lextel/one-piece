<ul class="edit_product">
{{# products }}
        <li>
        	<a href="/products/view/{{ id }}/{{ periodId }}" target="_blank">{{ title }}</a>
            <span class="bottom_list">
            	<a href="/products/edit/{{ id }}">编辑</a>
                {{# isUp }}
                <a href="javascript:void(0);" class="listing_down" data-id="{{ id }}">下架</a>
                {{/ isUp }}
                {{# isDown }}
                <a href="javascript:void(0);" class="listing_up" data-id="{{ id }}">上架</a>
                {{/ isDown }}
                {{# isDowning }}
                <a href="javascript:void(0);">下架中</a>
                {{/ isDowning }}
            </span>
        </li>
{{/ products }}
{{^ products }}
    <li style="text-align: center; padding-bottom: 20px">还没有商品哦！~ <a href="/products/add">添加一个</a></li>
{{/ products }}
</ul>

<div id="listing_up" title="确认上架？" style="none">
    <p>确认上架？</p>
    <span style="color:red"></span>
</div>
<div id="listing_down" title="确认下架？" style="none">
    <p>进行此操作对正在云购的期无影响，下架完成操作将于下期开始执行。</p>
    <span style="color:red"></span>
</div>
<script type="text/javascript">

    $('#listing_up').dialog({
        autoOpen: false,
        height: 150,
        width: 300,
        modal: true,
        resizable: false,
        buttons: {
            '上架': function() {
                var id = $(this).attr('data-id');
                var tagId = $('#tag_id').val();
                var url = '/products/listing/2/' + tagId + '/' + id;
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 1) {
                            $('#listing_up').dialog('close');
                            window.location.href = window.location.href;
                        } else {
                            $('#listing_up').find('span').html('上架失败！');
                        }
                    }
                });

            },
            '取消': function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $('#listing_down').dialog({
        autoOpen: false,
        height: 150,
        width: 300,
        modal: true,
        resizable: false,
        buttons:{
            '下架': function() {
                var id = $(this).attr('data-id');
                var url = '/products/listing/1/' + id;
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 1) {
                            $('#listing_down').dialog('close');
                            window.location.href = window.location.href;
                        } else {
                            $('#listing_down').find('span').html('下架失败！');
                        }
                    }
                });

            },
            '取消': function() {
                $(this).dialog('close');
            }
        }
    });

    // 上架
    $('.listing_up').click(function() {
        var id =  $(this).attr('data-id');
        $('#listing_up').attr('data-id', id);
        $('#listing_up').dialog('open');
    });

    // 下架
    $('.listing_down').click(function(){
        var id =  $(this).attr('data-id');
        $('#listing_down').attr('data-id', id);
        $('#listing_down').find('span').html('');
        $('#listing_down').dialog('open');
    });




</script>
