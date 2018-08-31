<?php
/**
 * 侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<aside>
	<!-- 热门文章 -->
	  <div class="tuijian">
        <ol>
        <h2>热门文章</h2>
          <?php widget_hotlog("热门文章");?>
        </ol>
      </div>
	<!-- 标签 -->
    <div class="sunnav">
    <h2><span>标签</span></h2>
    	<?php widget_tag('标签');?>

 	</div>
	<!-- 分类 -->
	<div class="search">
		<h2><span>分类</span></h2>
		<?php widget_sort("分类");?>

	</div>
	<!-- 归档 -->
	<div class="search">
        <h2>归档</h2>
        <ol>
        <?php widget_archive('归档');

        ?>

        </ol>
    </div>

<!-- 搜素 -->
	<div class="search">
		<?php widget_search("搜素");?>
	</div>
	<!-- 日历 -->
	<div class="search">
		<?php widget_calendar("日历");?>
	</div>
  <div class="viny">
        <dl>
          <dt class="art"><img src="<?php echo TEMPLATE_URL; ?>style/images/artwork.png" alt="专辑"></dt>
          <dd class="icon-song"><span></span>好听</dd>
          <dd class="icon-artist"><span></span>歌手：好听</dd>
          <dd class="icon-album"><span></span>所属专辑：none</dd>
          <dd class="icon-like"><span></span><a href="javascript:void(0)">总共两首,刷新随机换歌</a></dd>
          <dd class="music">



            <audio src="#" type="audio/mpeg"	controls="controls"></audio>

          </dd>
          <!--也可以添加loop属性 音频加载到末尾时，会重新播放-->
        </dl>
  </div>


</aside>
</div>
</div>

<?php if (Option::get('rss_output_num')):?>
<li style="padding-left:0;background:none;">
<div class="rss">
<a href="<?php echo BLOG_URL; ?>rss.php" title="RSS订阅"><img src="<?php echo TEMPLATE_URL; ?>images/rss.gif" alt="订阅Rss"/></a>
</div>
</li>
<?php endif;?>

</ul><!--end #siderbar-->
