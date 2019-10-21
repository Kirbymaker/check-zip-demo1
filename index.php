<?php
if(isset($_POST['files']))
{
$error = ""; // 에러 메시지 출력
if(isset($_POST['createzip']))
{
$post = $_POST; 
$file_folder = ""; // 파일 불러오기 경로
if(extension_loaded('zip'))
{ 
// 압축 프로그램 확인
if(isset($post['files']) and count($post['files']) > 0)
{ 
// 파일 선택 체크
$zip = new ZipArchive(); // 압축 프로그램 불러오기
$zip_name = time().".zip"; // 압축 파일 확장자
if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
{ 
 // zip 파일 생성
$error .= "* 파일 압축에 실패하였습니다.";
}
foreach($post['files'] as $file)
{ 
$zip->addFile($file_folder.$file); // zip 파일에 선택한 파일들 압축
}
$zip->close();
if(file_exists($zip_name))
{
// zip 파일 다운로드
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="'.$zip_name.'"');
readfile($zip_name);
// 다운로드 후 서버에서 zip 파일 삭제
unlink($zip_name);
}

}
else
$error .= "* 다운로드할 파일을 선택하세요.";
}
else
$error .= "* 이 브라우저는 압축을 지원하지 않습니다.";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>여러 파일 zip 다운로드 데모1</title>
<meta charset="utf-8">
</head>
<body>
<h1>여러 파일 zip 다운로드 데모1</h1>
<form name="zips" action="" method="post">
<input type="checkbox" id="checkAll" /><label>모두 선택</label><br />
<input class="chk" type="checkbox" name="files[]" value="2015 수학 교육과정.png"/><label>2015 수학</label><br />
<input class="chk" type="checkbox" name="files[]" value="2015 물리 교육과정.jpg"/><label>2015 물리</label><br />
<input class="chk" type="checkbox" name="files[]" value="2015 지구 교육과정.png"/><label>2015 지구</label><br />
<input type="submit" id="submit" name="createzip" value="선택한 파일들 다운로드" >
</form>

<script src="./jquery-1.11.0.min.js"></script>
<script type="text/javascript">
$('#submit').prop("disabled", true);
$("#checkAll").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
	  $('#submit').prop("disabled", false);
	  if ($('.chk').filter(':checked').length < 1){
			$('#submit').attr('disabled',true);}
});

$('input:checkbox').click(function() {
        if ($(this).is(':checked')) {
			$('#submit').prop("disabled", false);
        } else {
		if ($('.chk').filter(':checked').length < 1){
			$('#submit').attr('disabled',true);}
		}
});		
</script>
</body>
</html>
