
@extends('layouts.install')
@section('title', 'Install - Requirments')
@section('content')

    <?php
          $phpversion = phpversion();
          $mbstring = extension_loaded('mbstring');
          $bcmath = extension_loaded('bcmath');
          $ctype = extension_loaded('ctype');
          $json = extension_loaded('json');
          $openssl = extension_loaded('openssl');
          $pdo = extension_loaded('pdo');
          $tokenizer = extension_loaded('tokenizer');
          $xml = extension_loaded('xml');
          $fileinfo = extension_loaded('fileinfo');
          $fopen = ini_get('allow_url_fopen');
          $imap = extension_loaded('imap');
          $iconv = extension_loaded('iconv');
          $zip = extension_loaded('zip');

          $info = [
            'phpversion' => $phpversion,
            'mbstring' => $mbstring,
            'bcmath' => $bcmath,
            'ctype' => $ctype,
            'json' => $json,
            'openssl' => $openssl,
            'pdo' => $pdo,
            'tokenizer' => $tokenizer,
            'xml' => $xml,
            'fileinfo' => $fileinfo,
            'allow_url_fopen' => $fopen,
            'imap' => $imap,
            'iconv' => $iconv,
            'zip' => $zip,
          ];
          ?>

          <!-- requirments-section-start -->
          <section class="mt-80 mb-80">
            <div class="requirments-section">
              <div class="content-requirments d-flex justify-content-center">
                <div class="requirments-main-content">
                  <div class="installer-header text-center">
                    <h2>{{ __('Requirments') }}</h2>
                    <p>{{ __('Please make sure the PHP extentions listed below are installed') }}</p>
                  </div>
                  <div class="card">
                    <table class="table requirments">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">{{ __('Extentions') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ __('PHP >= 7.4') }}</td>
                            <td>
                              <?php 
                              if ($info['phpversion'] >= 7.4) { ?>
                                <i class="fas fa-check"></i>
                                <?php
                              }else{ ?>
                                <i class="fas fa-times"></i>
                                <?php
                              } 
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>{{ __('BCMath PHP Extension') }}</td>
                            <td>
                              <?php 
                              if ($info['bcmath'] == 1) { ?>
                                <i class="fas fa-check"></i>
                                <?php
                              }else{ ?>
                                <i class="fas fa-times"></i>
                                <?php
                              } 
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>{{ __('ZIP PHP Extension') }}</td>
                            <td>
                              <?php 
                              if ($info['zip'] == 1) { ?>
                                <i class="fas fa-check"></i>
                                <?php
                              }else{ ?>
                                <i class="fas fa-times"></i>
                                <?php
                              } 
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>{{ __('Iconv PHP Extension') }}</td>
                            <td>
                              <?php 
                              if ($info['iconv'] == 1) { ?>
                                <i class="fas fa-check"></i>
                                <?php
                              }else{ ?>
                                <i class="fas fa-times"></i>
                                <?php
                              } 
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>{{ __('Ctype PHP Extension') }}</td>
                            <td>
                             <?php 
                             if ($info['ctype'] == 1) { ?>
                              <i class="fas fa-check"></i>
                              <?php
                            }else{ ?>
                              <i class="fas fa-times"></i>
                              <?php
                            } 
                            ?>
                          </td>
                        </tr>
                        <tr>
                            <td>{{ __('IMAP PHP Extension') }}</td>
                            <td>
                             <?php 
                             if ($info['imap'] == 1) { ?>
                              <i class="fas fa-check"></i>
                              <?php
                            }else{ ?>
                              <i class="fas fa-times"></i>
                              <?php
                            } 
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td>{{ __('JSON PHP Extension') }}</td>
                          <td>
                           <?php 
                           if ($info['json'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('Mbstring PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['mbstring'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('OpenSSL PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['openssl'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('PDO PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['pdo'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('Tokenizer PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['tokenizer'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('XML PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['xml'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('Fileinfo PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['fileinfo'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('Fopen PHP Extension') }}</td>
                        <td>
                          <?php 
                          if ($info['allow_url_fopen'] == 1) { ?>
                            <i class="fas fa-check"></i>
                            <?php
                          }else{ ?>
                            <i class="fas fa-times"></i>
                            <?php
                          } 
                          ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  
              <?php 
              $page_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              if ($info['phpversion'] >= 7.4 && $info['mbstring'] == 1 && $info['imap'] == 1 && $info['zip'] == 1 && $info['iconv'] == 1  && $info['bcmath'] == 1 && $info['ctype'] == 1 && $info['json'] == 1 && $info['openssl'] == 1 && $info['pdo'] == 1 && $info['tokenizer'] == 1 && $info['xml'] == 1 && $info['fileinfo'] == 1 && $info['allow_url_fopen'] == 1) { ?>
                <a href="{{ route('install/step1') }}" class="btn btn-primary install-btn f-right w-100">{{ __('Next') }}</a>
                <?php
              }else{ ?>
               <a href="#" class="btn btn-primary f-right disabled w-100">{{ __('next') }}</a>
               <?php
             }
             ?>
           </div>
         </div>
       </div>
     </section>
@stop