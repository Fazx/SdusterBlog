<?php
                    $articletitle = strip_tags($articletitle);
            		print<<<EOT
            	<article class="post post- $articleid ">
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="./detail.php?articleid=$articleid"> $articletitle </a>
                        </h2>
                        <div class="entry-meta">
                            <span class="post-category"><a href="./category.php?categoryid=$articlecategoryid"> $categoryname </a></span>
                            <span class="post-date"><a href="#"><time class="entry-date"
                                                                      datetime= $articlepostdatetime"> $articlepostdatetime </time></a></span>
                            <span class="post-author"><a href="./auther.php?autherid=$userid"> $username </a></span>
                            <span class="views-count"><a href="./detail.php?articleid=$articleid"> $articleclick 阅读</a></span>
EOT;
                    if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1){
                        echo '<span class="views-count"><a href="./delete.php?articleid='.$articleid.'"> 删除 </a></span>';
                    }
                    echo '</div>';
                    echo '</header>';

?>
