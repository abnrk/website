#!/usr/bin/nim e
# Searx Randomizer for CGI+NimScript
import std/random
import std/envvars
when defined(js):
  import std/dom

randomize()

let instances: array[29,string] = ["darmarit.org/searx", "fairsuch.net", "northboot.xyz", "nyc1.sx.ggtyler.dev", "search.citw.lgbt", "search.datura.network", "search.hbubli.cc", "search.im-in.space", "search.indst.eu", "search.mdosch.de", "search.nadeko.net", "search.nerdvpn.de", "search.ngn.tf", "search.ononoki.org", "search.rowie.at", "search.us.projectsegfau.lt", "searx.baczek.me", "searx.colbster937.dev", "searx.daetalytica.io", "searx.dresden.network", "searx.lunar.icu", "searx.namejeff.xyz", "searx.tuxcloud.net", "searx.work", "searxng.site", "sx.catgirl.cloud", "sxng.violets-purgatory.dev", "www.gruble.de", "xo.wtf"]
when defined(js):
  let params_cstring = window.location.search
  let params_string: string = $params_cstring
  let params: string = params_string[1 .. len(params_string)-1]
else:
  let params: string = getEnv("QUERY_STRING")
let url: string = "https://" & sample(instances) & "/search?" & params

when defined(js):
  document.body.innerHTML = cstring("<meta http-equiv=\"refresh\" content=\"0;url=" & url & "\">")
else:
  echo "Status: 307 Temporary Redirect"
  echo "Location: ",url
  echo "Content-Type: text/html\n\n"