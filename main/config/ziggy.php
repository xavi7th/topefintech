<?php

return [
  'groups' => [
    'admin' => [
      'admin.*',
      'appuser.*',
      'app.*',
    ],
    'appuser' => [
      'appuser.*',
      'app.*',
    ],
    'basic' => [
      'app.*',
    ],
  ],
];
