<?php
function makeData($page) {
    $user = (object)array('name'=>'Unknown','id'=>null);
    return (object)array(
        'page'=>$page,
        'skipLayout'=>false,
        'user'=>$user);
} 
//Front page
$app->get('/',function() {
    
    if (is_loggedin()) {
        redirect("/dashboard");
    }
    $data = makeData('home');
    $data->skipLayout = true;
    render('base', $data);
});

//Dashboard
$app->get('/settings',function() {
    if (!is_loggedin())
        redirect("/");
    render('base',makeData('settings'));
});


//Dashboard
$app->get('/dashboard',function() {
    if (!is_loggedin())
        redirect("/");
    render('base',makeData('dashboard'));
});

//Log out
$app->get('/logout',function() {
    session_destroy();
    redirect("/");
});

//Ajax list call
$app->get('/_list',function() {
    if (!is_loggedin()) {
        error(401,"Unauthorized");
    }
    
    $data = (object)array(
        'rows' => array()
    );
    
    render('list',$data);
});

//Ajax stats call
$app->get('/_stats',function() {
    if (!is_loggedin()) {
        error(401,"Unauthorized");
    }
    
    $data = (object)array(
        'cols' => array()
    );
    
    render('list',$data);
});
