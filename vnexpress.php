<?php 
    /*
    *   A SIMPLE EXAMPLE OF WEB SCRAPING WITH PHP
    *   Use: http://simplehtmldom.sourceforge.net/
    **/
    include('simple_html_dom.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leech bài viết từ VNExpress</title>
    <style>
        *{
            margin:0;
            padding:0;
        }
        #header{
            background-color: blue;
            color:white;
            height:50px;
            line-height:50px;
            text-align:center;
        }
        #content{
            margin: 2% 10%;
        }
        #footer{
            background-color: black;
            color:white;
            height:50px;
            line-height:50px;
            text-align:center; 
        }
    </style>
</head>
<body>
    <div id="header">
        <h1>Leech VnExpress.Net</h1>
    </div>
    <div id="content">
        <?php
            if($_SERVER['REQUEST_METHOD'] != 'POST'){
        ?>
            <form method='post'>
                <table>
                    <tr>
                        <td>Link cần leech: </td>
                        <td><input type="text" name="url"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Leech"></td>
                    </tr>
                </table>
            </form>
        <?php
            }else{
                $url = $_POST['url'];
                $html = file_get_html($url, false, null, 0);
                $title = $html->find("h1[class='title_news_detail mb10']",0);
                $content = $html->find("article[class='content_detail']", 0)->outertext;

                $pattern_open_tag = "'<article (.*?)>'si";
                $end_tag = '</article>';
                $content = preg_replace ($pattern_open_tag,"",$content);
                $content = str_replace($end_tag,"",$content);
                $content = trim($content);
                if($title == null || $content == null)
                {
                    echo "Lỗi vui lòng kiểm tra lại link. Nếu link đúng k được vui lòng liên hệ admin";
                }else{
        ?>
                    <span>Tiêu đề: </span><br/>
                    <textarea rows="5" cols="100"><?=$title->plaintext?></textarea><br/>
                    <span>Nội dung:</span>
                    <br/>
                    <textarea rows="23" cols="100"><?=$content?></textarea>
        <?php
                }
            }
        ?>
    </div>
    <div id="footer">
        <b>@2018 - TruongTC</b>
    </div>
</body>
</html>