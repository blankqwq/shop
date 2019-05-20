<?php
return [
    'alipay' => [
        'app_id' => '2016093000629402',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7LlGqRm1y5N30aYKc7oagxcgusHbUh5gOt23CASKqJj8LCIHhLUJkOoMTzyTf7G4lSJ4NJh582F12ICMYBoCbcrroJAx0Y70qBaBMIBehhniG4RaO/p26TxGJEBOGfw4SlmbX4oR/DjCA4s9SZKYau1EI2gQNkevwmjBEYcR5ScCC/FYPKW8CPf4fsV5N4ZohyLSR3wXa61DMS3kUA+R51bxXIfSS7NwweYtHIfLZUf0KsuJnuo436Gx1DR2K0Vua4XHpBeCSsCSjfHazTfJxV9phjI4bMR8HJbq1MI4ajXHtjLgbuGEXnTJB8xzm9vgS2r54hegjxAL4euivsJI6wIDAQAB',
        'private_key' => 'MIIEowIBAAKCAQEA2nnxKf6/PnN0q6DyZ52ndXghaEmutmH2zwcp323EWK8o33j3SwS9wxveLis27361dtRdmbWJpO6GTZOHRjvhZ5auVBPB21xMX72CsCe29RZZafYZxC/Mqt2h8jw76LeBmOyz969uqtQ4dZLbO8XN/KDf0PNj2cWGjF1R0CTLx2H40S+IJKIi+X2Bw8/8Z9zK0Mag37NPZf7/5rDbV3CvRewGcsbZdTGE4aeXWAiN3qoy0BHLOwr2FR+k1V2YdmVY7dO/zn3eI9bry2cLAG6hIsIPJiaDk9NECJSRwRRSo61ktEIXcgDSecK+t+W1kX12r6VoG5VlEA7yGbBasLxBKQIDAQABAoIBAGRnAeOQxQbIPGfbcUsY8qpTaNbqdbYvUyNVYXLimQdAiAIbL1p0dVjC59pD1d0+V9qiQdmvye/YBjSEhfhK8I2Qe9D7u205/4dIKlUWC0ia2sCNbs3wQZiMfi46bDXIj3Bd517+aldra/7sXIAdqUpeDD2UfODJm8nJ4R1Mq7GWhRqCH/0bsh+i7DaBv+boO/6a3TmwTBX5Ws2/yQuDjCLx1Ydcw9tJo6CyP7yj31qv+rW08e9/aUy7+F25Zj+jr6GLv3kw5iYhRjy8wDCVioO6qs+80sf+sIry2ncvFryyEoQ1XpR2petbVNaKuXgpxZq8xdAnHLBqr5Ap6RTnqXkCgYEA9nSGwnMA56eCVV3gBxToTgMGlAJWtBr0u73X64qIvsFQkXG9dGotaVg1DkUW+pE85hhhga7h8OgbTpkasyozXH1ygtppEXYMQ0D8l9B/GJ9Y3O/WdBOPagle6YfAcuepeyGeKysdtcgYsaeynGHzs79m/fGDYGm9VkVrYNdaPCcCgYEA4vAFJRpvrw+AxrF3v82XJqQ/Ev82YEAhiEkOmSzmG0SwMVoHNVdVGpUCIQtu3S3Ha7X5fdFwojOnL4MvvLXVI65ZcYr343MqCocGQyJsUce5G4xIqUY3GN2BDmR1vP0Zw4q4KbuL3aigccnF7PHV1mp4G3s8j779pZjKpt2+2i8CgYAFKsBAh2S3dp2W6JbvzxJnwEx9AeeLcx06amqCd68SQL9NrVLJhAhbswu5tt0ad70NHem9bEs0X8lixnb21qWpBMBH2ghl41Gyf0RMcoSXoY+dYjHe0SIqmPOydbQlNJIrELNeOFMxInbSEq/981fGpvaj0FJuzQi5LE9qAlnT9QKBgFd2PeVg3O5RQUZSm15WtAx2fMCrj59k2AeYcIHkZgLYZDeBBQov0GLgTuPBbkbcH+GJTtCI6an50lNjcgB+69hGl75E2ujUN7268FTrbWfPW64cUNy8bPuuUtDjMuVVfpp4WiXrXCpflQaFxzxcsBdlDUk6I8saxtMNofzRtX6NAoGBALF+VyRXeU7vWa5tReuO1xEjiuC1RoPsa2Ln4+mW/KQZAnZMuHmQEqAy6D1i87XMkOJCyNTIrmZf0scZLrDm9Hc1ho/GjZy8R3AzuaVfk2K9TnVFlLIWrPAdbardW22y3llezsTTGBCVJbAgzcwy0AfSMnXUMTqL59+Lq80G5qLu',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
        'mode' => 'dev'
    ],

    'wechat' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_client' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],],
];