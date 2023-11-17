<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

use Google\Client;
use Google\Service\Drive;

/**
 * Returns an authorized API client.
 * @return Client the authorized client object
 * @throws \Google\Exception
 */
function getClient(): Client
{
    $client = new Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes('https://www.googleapis.com/auth/drive');
    $client->setAuthConfig('iamcredentialspersonal.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
//    $tokenPath = 'token.json';
//    if (file_exists($tokenPath)) {
//        $accessToken = json_decode(file_get_contents($tokenPath), true);
//        $client->setAccessToken($accessToken);
//        var_dump('Access token: '.$accessToken['access_token']) ;
//    }

    // If there is no previous token or it's expired.
//    try{
//
//
//        if ($client->isAccessTokenExpired()) {
//            // Refresh the token if possible, else fetch a new one.
//            if ($client->getRefreshToken()) {
//                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
//            } else {
//                // Request authorization from the user.
//                $authUrl = $client->createAuthUrl();
//                printf("Open the following link in your browser:\n%s\n", $authUrl);
//                print 'Enter verification code: ';
//                $authCode = trim(fgets(STDIN));
//
//                // Exchange authorization code for an access token.
//                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
//                $client->setAccessToken($accessToken);
//
//                // Check to see if there was an error.
//                if (array_key_exists('error', $accessToken)) {
//                    throw new Exception(join(', ', $accessToken));
//                }
//            }
//            // Save the token to a file.
//            if (!file_exists(dirname($tokenPath))) {
//                mkdir(dirname($tokenPath), 0700, true);
//            }
//            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
//        }
//    }
//    catch(Exception $e) {
//        // TODO(developer) - handle error appropriately
//        echo 'Some error occured: '.$e->getMessage();
//    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Drive($client);

// Print the names and IDs for up to 10 files.
$optParams = array(
    'pageSize' => 100,
    'fields' => 'nextPageToken, files(id, name)',
);
//// Print the names and IDs for up to 10 folder.

//$folderId = createFolder('Test3');

//$optParams = array(
//    'q' => "mimeType='application/vnd.google-apps.folder' and trashed= false",
//);
$results = $service->files->listFiles($optParams);

if (count($results->getFiles()) == 0) {
    print "No files found.\n";
} else {
    print "Files:\n";
    foreach ($results->getFiles() as $file) {
        printf("%s (%s)\n", $file->getName(), $file->getId());
//        var_dump($file);
//        createFolder('Templates', $file->getId());
    }
}

$client = getClient();
$client->addScope(Drive::DRIVE);
$driveService = new Drive($client);
$driveService->getClient()->setUseBatch(true);

$batch = $driveService->createBatch();

$userPermission = new \Google\Service\Drive\Permission(array(
    'type' => 'user',
    'role' => 'writer',
    'emailAddress' => 'kevinnaguirre9@gmail.com'
));

$request = $driveService->permissions->create(
    '1Qn329iSxhC1LC_qxKjQTzSvei5b-wImR', $userPermission, array('fields' => 'id'));

$batch->add($request,'user');

$results = $batch->execute();

$driveService->getClient()->setUseBatch(false);

foreach ($results as $result) {
    if ($result instanceof Google_Service_Exception) {
        // Handle error
        printf($result);
    } else {
        printf("Permission ID: %s\n", $result->id);

    }
}


//$folderId = createFolder('another folder');

//var_dump($folderId->getId());
//uploadToFolder('1Qn329iSxhC1LC_qxKjQTzSvei5b-wImR');

function createFolder($name)
{
    try {
        $client = getClient();
        $client->addScope(Drive::DRIVE);
        $driveService = new Drive($client);
        $fileMetadata = new Drive\DriveFile([
            'name' => $name,
            'writersCanShare'=>true,
            'parents' => array('1FIMp5NRy0lf19fBTSESxwtWn0cUCaa4I'),
            'mimeType' => 'application/vnd.google-apps.folder']);
        $folderId = $driveService->files->create($fileMetadata);

        return $folderId;

    }catch(Exception $e) {
        echo "Error Message: ".$e;
    }
}

//$folderId = createFolder();
//
//var_dump($folderId->id); 1rHLF2DDVzhBigcLtS0LPMGsYBdQGSV-I

//1Qn329iSxhC1LC_qxKjQTzSvei5b-wImR
function uploadToFolder($folderId)
{
    try {
        $client = getClient();
        $client->addScope(Drive::DRIVE);
        $driveService = new Drive($client);
        $fileMetadata = new Drive\DriveFile([
            'name' => 'test.xlsx',
            'parents' => array($folderId)
        ]);
        $content = file_get_contents('test.xlsx');
        $file = $driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'uploadType' => 'multipart',
            'fields' => 'id']);
        printf("File ID: %s\n", $file->id);

//        $driveService->getClient()->setUseBatch(true);
//
//        $batch = $driveService->createBatch();
//
//        $userPermission = new \Google\Service\Drive\Permission(array(
//            'type' => 'user',
//            'role' => 'writer',
//            'emailAddress' => 'kevin.aguirre@funiber.org'
//        ));
//        $request = $driveService->permissions->create(
//            $file->id, $userPermission, array('fields' => 'id'));
//
//        $batch->add($request,'user');
//
//        $results = $batch->execute();
//
//        $driveService->getClient()->setUseBatch(false);
//
//        foreach ($results as $result) {
//            if ($result instanceof Google_Service_Exception) {
//                // Handle error
//                printf($result);
//            } else {
//                printf("Permission ID: %s\n", $result->id);
//
//            }
//        }
//        return $file->id;

    } catch (Exception $e) {
        echo "Error Message: " . $e;
    }
}

//uploadToFolder('1rHLF2DDVzhBigcLtS0LPMGsYBdQGSV-I'); // file id 1B0l7qRYvUefKZPfhg7VSjt5uVS1WXWvB



