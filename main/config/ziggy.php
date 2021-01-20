<?php

return [
  'except' => ['_debugbar.*','debugbar.*', 'ignition.*', 'horizon.*', 'admin.*', 'superadmin.*'],
  'groups' => [
    'superadmin' => [
      'superadmin.*',
    ],
    'admin' => [
      'admin.*',
    ],
    'agent' => [
      'agent.*',
      'auth.*'
    ],
    'appuser' => [
      'appuser.*',
      'auth.*'
    ],
    'basic' => [
      'app.*',
    ],
  ],
];
