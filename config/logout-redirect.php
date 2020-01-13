<?php

return [
    // Enable the redirect check
    'enabled' => true,
    
    // To redirect all users after logout - this will override the two other config options
    'redirectUrl' => '/login',
    
    // To redirect CP users after logout
    // 'redirectCpUrl'   => '/logine',
    
    // To redirect site users after logout
    // 'redirectSiteUrl' => '/login',
];