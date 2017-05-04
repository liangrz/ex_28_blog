环境情况
==
  里面的文件引用原本是基于admin这个文件夹里面的全部文件都放置在根目录.
  因为被要求，所以要把现在admin里面的文件（之前是在根目录）装载到admin文件夹里头
通过path.php试图自己把里面的文件引用自动修正成文件移动后的引用

4-11 第一次测试
--
  评论表导入失败？    
  分析：可能是深度Deepth问题    
  后来发现了index.php里面是通过pick_show.php里面include('./comment_form.html')显示评论表\<br>    
  index.php导入之后pick_show.php后，所有pick_show.php里的函数引用都是以index.php作为相对路径的起点\<br>    
  而path.php修改的路径，是include里文件路径和包含该include的文件路径为对象而修改成的相对路径，comment_form.html是在pick_show.php上级路径，所以自动把pick_show.php里面的include('./comment_form.html'),改成include('.././comment_form.html');\<br>    
  所以在index.php导入pick_show.php之后，以index.php作为起点寻找.././comment_form.html根本找不到。\<br>    
  
  相关文件列表\<br>     
  | index.php\<br>    
  | comment_form.html\<br>    
  |-func\<br>    
      |-pick.show.php\<br>   
      
5-4 
--
之前接触__autoload和mvc之后就发现这个正则没用，不过接触到模板引擎和框架，就大概感觉到里面的独特语法都是用正则替换，虽然运行速度不快，但是开发快
