<?php


namespace App;


class Icons
{
    protected $icons = [
        '1f242d1d-07eb-49be-b2c5-9133689d702f' => 'https://pbs.twimg.com/profile_images/839783830735183872/15HM-5XC_400x400.jpg',
        '89cb31a6-961a-488f-9ea9-f333abe2b9e7' => 'https://pbs.twimg.com/profile_images/635772916257452032/YK8b77i__400x400.jpg',
        'b8600bf9-dc0a-4eac-826e-a8cc765d4efd' => 'https://pbs.twimg.com/profile_images/378800000715190627/f743b0a48c2373e8e91448b2ca97e2b1_400x400.jpeg',
        '333ba583-3720-48c4-9bd1-b83f9f880380' => 'https://pbs.twimg.com/profile_images/883602401453854720/HtMLKFSB_400x400.jpg'
    ];

    protected $default = '/img/default_icon.png';

    public function get(string $merchantID)
    {
        if ( array_key_exists($merchantID, $this->icons)) {
            return $this->icons[$merchantID];
        }

        return $this->default;
    }
}