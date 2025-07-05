<?php

// app/Config/App.php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    // Session Configuration
    public $sessionDriver = 'CodeIgniter\Session\Handlers\DatabaseHandler';
    public $sessionCookieName = 'ci_session';
    public $sessionExpiration = 86400; // 24 hours
    public $sessionSavePath = 'ci_sessions'; // Ensure this is set correctly for your database
    public $sessionMatchIP = false;
    public $sessionTimeToUpdate = 600; // Time in seconds to regenerate session ID (10 minutes)
    public $sessionRegenerateDestroy = false;

    // Base Site URL
    public string $baseURL = 'http://192.168.10.176:8012/Adjusment-Inventory/public/';

    // Allowed Hostnames
    public array $allowedHostnames = []; // Add allowed hostnames if needed

    // Index File
    public string $indexPage = 'index.php';

    // URI Protocol
    public string $uriProtocol = 'REQUEST_URI'; // Default is usually fine

    // Allowed URL Characters
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    // Default Locale
    public string $defaultLocale = 'en';

    // Negotiate Locale
    public bool $negotiateLocale = false;

    // Supported Locales
    public array $supportedLocales = ['en'];

    // Application Timezone
    public string $appTimezone = 'Asia/Jakarta';

    // Default Character Set
    public string $charset = 'UTF-8';

    // Force Global Secure Requests
    public bool $forceGlobalSecureRequests = false;

    // Reverse Proxy IPs
    public array $proxyIPs = []; // Add IP addresses if behind a reverse proxy

    // Content Security Policy
    public bool $CSPEnabled = false;

    // Cookie Configuration
    public $cookieExpire = 86400; // 24 hours
}
