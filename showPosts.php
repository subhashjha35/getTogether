<?php
    include "dbController.php";
    if(isset($_GET['comment_text'])){
        $comment_text=$_GET['comment_text'];
        $user=$_GET['user'];
        $post_id=$_GET['post_id'];
        $comment=new PostComment();
        $comment->createPostComment($post_id,$user,$comment_text);
        $res=$comment->showPostComment($post_id,5);
        while($row=$res->fetch_assoc()):
        ?>
            <div class="" style="background:#ccc;"><?=$row['username'];?> : <?=$row['comment_body'];?></div>
        <?php
        endwhile;
    }
    else{
        $post=new Post();
        $res=$post->showPosts();

        while($row=$res->fetch_assoc()):
            $post_id=$row['posts_id'];
            $post_text=$row['post_text'];
            $post_object=$row['post_object'];
            $object_type=$row['post_object_type'];
            $uname=$row['user_id'];
            $name=$row['name'];
            $time=$row['post_time'];
            $user_pic=$row['profile_pic'];
            $time=strtotime($time);
            /*echo $time;*/
            $t=time()-$time;

            /*echo "<br>".$t;*/
            if($t>=(60*60*24*365.25))
                $new_t=floor($t/(60*60*24*365.25))." year";
            else if($t>=60*60*24*30){
                $new_t=floor($t/(60*60*24*30))." months";
            }
            else if($t>=60*60*24){
                $new_t=floor($t/(60*60*24))." days";
            }
            else if($t>=60*60){
                $new_t=floor($t/(60*60))." hours";
            }
            else if($t>=60){
                $new_t=floor($t/(60))." minutes";
            }
            else{
                $new_t=floor($t)." seconds";
            }
            ?>
            <div class="post-list bg-warning">
                <div class="row">
                    <div class="col-md-2 col-xs-3">
                        <img src="<?=$user_pic;?>" alt="" class="img-responsive img-rounded">
                    </div>
                    <div class="col-md-9 col-xs-8">
                        <a href="#"><span class="h4"><?=$name;?></span><br><span class="h5">@<?=$uname;?></span></a>
                        <span><?=$new_t;?></span>
                    </div>
                    <div class="col-md-1 col-xs-1" style="position: relative;">
                        <nav class="navbar navbar-default navbar-right" style="inline-block; position:absolute;right:20px">
                            <ul class="nav navbar-nav">
                                <li class="dropdown"><a href="#" class="" data-toggle="dropdown"><span class="fa fa-edit"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Unfriend User</a></li>
                                        <li><a href="#">Report this Post</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p><?=$post_text;?></p>
                    </div>
                </div>
                <div class="text-center">
                    <?php
                    if($object_type=="picture"):
                        ?>
                        <img src="<?=$post_object;?>" alt="" class="img-responsive">
                        <?php
                    elseif($object_type=="video"):
                        ?>
                        <video class="img-responsive" controls>
                            <source src="<?=$post_object;?>">
                        </video>
                        <?php
                    elseif($object_type=="file"):
                        ?>

                        <?php
                    endif;
                    ?>
                </div>
            <div>
            <div style="background:#fff;">
                <a href="#"><span class="fa fa-heart-o"> <span>12</span> </span> Likes</a> | <a href="#"><span>5</span> Comments</a>
            </div>
            <div class="input-group">
                <div class="input-group-addon">
                    <img src="./resources/images/user(256).jpg" alt=""height="20px">
                </div>
                <input type="text" class="form-control" id="<?="post_text".$post_id;?>">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary" id="<?=$post_id;?>"onclick="insert_comment(this.id)">Comment</button>
                </div>
            </div>
            <div id="<?='comment-list-box'.$post_id;?>">
                <?php
                $comment=new PostComment();
                $res1=$comment->showPostComment($post_id,5);
                while($row1=$res1->fetch_assoc()) {
                    ?>
                    <div class="" style="background:#ccc;"><?= $row1['username']; ?> : <?= $row1['comment_body']; ?></div>
                    <a class="alert alert-danger">View All</a>
                    <?php
                }
                ?>
            </div>

        </div>

            </div>
        <?php endwhile;
    }


?>