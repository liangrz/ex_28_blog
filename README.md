环境情况
==
  里面的文件引用原本是基于admin这个文件夹里面的全部文件都放置在根目录.
  因为被要求，所以要把现在admin里面的文件（之前是在根目录）装载到admin文件夹里头
通过path.php试图自己把里面的文件引用自动修正成文件移动后的引用

4-11 第一次测试
--
  评论表导入失败？
  分析：可能是深度Deepth问题
  后来发现了index.php里面是通过pick_show.php里面include('./comment_form.html')显示评论表
  index.php导入之后pick_show.php后，所有pick_show.php里的函数引用都是以index.php作为相对路径的起点
  而path.php修改的路径，是include里文件路径和包含该include的文件路径为对象而修改成的相对路径，comment_form.html是在pick_show.php上级路径，所以自动把pick_show.php里面的include('./comment_form.html'),改成include('.././comment_form.html');
  所以在index.php导入pick_show.php之后，以index.php作为起点寻找.././comment_form.html根本找不到。
  
  相关文件列表
  | index.php
  | comment_form.html
  |-func
      |-pick.show.php
  
