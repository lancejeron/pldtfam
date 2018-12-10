<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body onLoad='occurrences();'>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
</body>
</html>
<script>
var emails='sam@jquery4u.com,admin@jquery4u.com,someone@jquery4u.com';
function occurrences(string, substring){
    var n=0;
    var pos=0;

    while(true){
        pos=string.indexOf(substring,pos);
        if(pos!=-1){ n++; pos+=substring.length;}
        else{break;}
    }
    return(n);
}
count= occurrences(emails,'@');
console.log(count);
</script>