<?php

class rex_var_ytils_rex_target extends rex_var
{
    protected function getOutput()
    {
        $addon = rex_addon::get('ytils_rex_target');

        $selfUrls = $addon->getConfig('ytilsRexTargetSelf');
        $topUrls = $addon->getConfig('ytilsRexTargetTop');
        $blankUrls = $addon->getConfig('ytilsRexTargetBlank');
        $parentUrls = $addon->getConfig('ytilsRexTargetParent');

        $behaviourOthers = $addon->getConfig('ytilsRexTargetBehaviourOthers');

        $selfUrlsArr = $this->configToStringArr($selfUrls);
        $topUrlsArr = $this->configToStringArr($topUrls);
        $blankUrlsArr = $this->configToStringArr($blankUrls);
        $parentUrlsArr = $this->configToStringArr($parentUrls);

        $selfUrlsJs = json_encode($selfUrlsArr);
        $topUrlsJs = json_encode($topUrlsArr);
        $blankUrlsJs = json_encode($blankUrlsArr);
        $parentUrlsJs = json_encode($parentUrlsArr);

        $jsInjection = <<<EOT
        <script>
            (function() {
                
                var inArray = function(needle, haystack) {
                
                    var length = haystack.length;
                    var i;
                    
                    for (i = 0; i < length; i += 1) {
                        
                        if (haystack[i] === needle) {
                            
                            return true;
                        }
                    }
                    
                    return false;
                };
                
                var parseUri = function(str) {
                    
                    var	o = parseUri.options;
                    var m = o.parser[o.strictMode ? "strict" : "loose"].exec(str);
                    var uri = { };
                    var i = 14;
                
                    while (i--) uri[o.key[i]] = m[i] || "";
                
                    uri[o.q.name] = {};
                    uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
                        if ($1) uri[o.q.name][$1] = $2;
                    });
                
                    return uri;
                };
                
                parseUri.options = {
                    
                    strictMode: false,
                    key: ["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"],
                    q: {
                        name:   "queryKey",
                        parser: /(?:^|&)([^&=]*)=?([^&]*)/g
                    },
                    parser: {
                        strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                        loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
                    }
                };
                
                var selfUrlsArr = {{selfUrlsArr}};
                var topUrlsArr = {{topUrlsArr}};
                var blankUrlsArr = {{blankUrlsArr}};
                var parentUrlsArr = {{parentUrlsArr}};
                var otherBehaviour = {{otherBehaviour}};
                                
                var allAs = document.getElementsByTagName("a");
                var allAsC = 0;
                if (allAs && allAs.length && allAs.length > 0) {
                    
                    allAsC = allAs.length;
                }
                
                var i = 0;
                var cHref;
                var parsedUri;
                var host;
                for (i = 0; i < allAsC; i += 1) {
                    
                    cHref = allAs[i].href;
                    parsedUri = parseUri(cHref);
                    if (parsedUri.host) {
                        
                        host = parsedUri.host.toLowerCase();
                        if (inArray(host, selfUrlsArr)) {
                            
                            allAs[i].target = "_self";
                            continue;
                        }
                        
                        if (inArray(host, topUrlsArr)) {

                            allAs[i].target = "_top";
                            continue;
                        }
                        
                        if (inArray(host, blankUrlsArr)) {

                            allAs[i].target = "_blank";
                            continue;
                        }
                        
                        if (inArray(host, parentUrlsArr)) {

                            allAs[i].target = "_parent";
                            continue;
                        }
                        
                        if (otherBehaviour !== "") {
                            
                            allAs[i].target = otherBehaviour;
                        }
                    }
                }

            }());
        </script>
        EOT;

        $jsInjection = str_replace('{{selfUrlsArr}}', $selfUrlsJs, $jsInjection);
        $jsInjection = str_replace('{{topUrlsArr}}', $topUrlsJs, $jsInjection);
        $jsInjection = str_replace('{{blankUrlsArr}}', $blankUrlsJs, $jsInjection);
        $jsInjection = str_replace('{{parentUrlsArr}}', $parentUrlsJs, $jsInjection);
        $jsInjection = str_replace('{{otherBehaviour}}', '"'.$behaviourOthers.'"', $jsInjection);

        return self::quote($jsInjection);
    }

    private function configToStringArr($configVal)
    {
        if (is_string($configVal)) {

            $configVal = strtolower(trim($configVal));
            if (!empty($configVal)) {

                $arr = preg_split('/\r\n|\r|\n/', $configVal);
                if (!empty($arr)) {

                    return $arr;
                }
            }
        }

        return array();
    }
}