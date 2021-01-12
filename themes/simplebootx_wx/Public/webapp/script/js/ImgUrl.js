function GetImgUrl(size, filepath) {
    try {
        if (!filepath || filepath.length < 18) {
            return "";
        }

        var temdata = filepath.split('/');
        var temurl = temdata[temdata.length - 1];
        filepath = temurl;


        //if (filepath.indexOf('\\') != -1 || filepath.indexOf('/') != -1 || filepath.length < 18) {
        //    return filepath;
        //}

        var dotIdx = filepath.lastIndexOf('.');
        var _idx = filepath.indexOf('_');
        var ext = filepath.substring(dotIdx);
        var temfilename = _idx > 0 ? filepath.substr(0, _idx - 13) : filepath.substr(0, dotIdx - 13);
        var temfilename1 = _idx > 0 ? filepath.substr(0, _idx) : filepath.substr(0, dotIdx);
        var zsize = "";
        switch (size) {
            case "S80":
                zsize = "?iopcmd=thumbnail&type=8&width=160&height=160";
                break;
            case "S80w":
                zsize = "?iopcmd=thumbnail&type=4&width=160";
                break;
            case "S80c":
                zsize = "?iopcmd=thumbnail&type=8&width=160&height=160";
                break;
            case "S80d":
                zsize = "?iopcmd=thumbnail&type=8&width=160&height=90";
                break;
            case "S120":
                zsize = "?iopcmd=thumbnail&type=8&width=160&height=160";
                break;
            case "S120w":
                zsize = "?iopcmd=thumbnail&type=4&width=160";
                break;
            case "S120c":
                zsize = "?iopcmd=thumbnail&type=8&width=160&height=160";
                break;
            case "S120d":
                zsize = "?iopcmd=thumbnail&type=8&width=160&height=90";
                break;
            case "S240":
                zsize = "?iopcmd=thumbnail&type=8&width=320&height=320";
                break;
            case "S240w":
                zsize = "?iopcmd=thumbnail&type=4&width=320";
                break;
            case "S240c":
                zsize = "?iopcmd=thumbnail&type=8&width=320&height=320";
                break;
            case "S240d":
                zsize = "?iopcmd=thumbnail&type=8&width=320&height=180";
                break;
            case "S360":
                zsize = "?iopcmd=thumbnail&type=8&width=320&height=320";
                break;
            case "S360w":
                zsize = "?iopcmd=thumbnail&type=4&width=320";
                break;
            case "S360c":
                zsize = "?iopcmd=thumbnail&type=8&width=320&height=320";
                break;
            case "S360d":
                zsize = "?iopcmd=thumbnail&type=8&width=320&height=180";
                break;
            case "S480":
                zsize = "?iopcmd=thumbnail&type=8&width=640&height=640";
                break;
            case "S480w":
                zsize = "?iopcmd=thumbnail&type=4&width=640";
                break;
            case "S480c":
                zsize = "?iopcmd=thumbnail&type=8&width=640&height=640";
                break;
            case "S480d":
                zsize = "?iopcmd=thumbnail&type=8&width=640&height=360";
                break;
            case "S640":
                zsize = "?iopcmd=thumbnail&type=8&width=640&height=640";
                break;
            case "S640w":
                zsize = "?iopcmd=thumbnail&type=4&width=640";
                break;
            case "S640c":
                zsize = "?iopcmd=thumbnail&type=8&width=640&height=640";
                break;
            case "S640d":
                zsize = "?iopcmd=thumbnail&type=8&width=640&height=360";
                break;
            default:
                zsize = "";
                break;
        }

        //switch (size) {

        //    case "S80":
        //        zsize = "_160";
        //        break;
        //    case "S80w":
        //        zsize = "_160lw";
        //        break;
        //    case "S80c":
        //        zsize = "_160c";
        //        break;
        //    case "S80d":
        //        zsize = "_160w169";
        //        break;
        //    case "S120":
        //        zsize = "_160";
        //        break;
        //    case "S120w":
        //        zsize = "_160lw";
        //        break;
        //    case "S120c":
        //        zsize = "_160c";
        //        break;
        //    case "S120d":
        //        zsize = "_120w169";
        //        break;
        //    case "S240":
        //        zsize = "_320";
        //        break;
        //    case "S240w":
        //        zsize = "_320lw";
        //        break;
        //    case "S240c":
        //        zsize = "_320c";
        //        break;
        //    case "S240d":
        //        zsize = "_320w169";
        //        break;
        //    case "S360":
        //        zsize = "_320";
        //        break;
        //    case "S360w":
        //        zsize = "_320lw";
        //        break;
        //    case "S360c":
        //        zsize = "_320c";
        //        break;
        //    case "S360d":
        //        zsize = "_320w169";
        //        break;
        //    case "S480":
        //        zsize = "_640";
        //        break;
        //    case "S480w":
        //        zsize = "_640lw";
        //        break;
        //    case "S480c":
        //        zsize = "_640c";
        //        break;
        //    case "S480d":
        //        zsize = "_640w169";
        //        break;
        //    case "S640":
        //        zsize = "_640";
        //        break;
        //    case "S640w":
        //        zsize = "_640lw";
        //        break;
        //    case "S640c":
        //        zsize = "_640c";
        //        break;
        //    case "S640d":
        //        zsize = "_640w169";
        //        break;


        //        //case "Cut":
        //        //    zsize = "_CUT";
        //        //    break;
        //        //case "Orig":
        //        //    zsize = "";
        //        //    break;
        //        //case "S80":
        //        //    zsize = "_80";
        //        //    break;
        //        //case "S80h":
        //        //    zsize = "_a80";
        //        //    break;
        //        //case "S80w":
        //        //    zsize = "_b80";
        //        //    break;
        //        //case "S80c":
        //        //    zsize = "_c80";
        //        //    break;
        //        //case "S120":
        //        //    zsize = "_120";
        //        //    break;
        //        //case "S120h":
        //        //    zsize = "_a120";
        //        //    break;
        //        //case "S120w":
        //        //    zsize = "_b120";
        //        //    break;
        //        //case "S120c":
        //        //    zsize = "_c120";
        //        //    break;
        //        //case "S240":
        //        //    zsize = "_240";
        //        //    break;
        //        //case "S240h":
        //        //    zsize = "_a240";
        //        //    break;
        //        //case "S240w":
        //        //    zsize = "_b240";
        //        //    break;
        //        //case "S240c":
        //        //    zsize = "_c240";
        //        //    break;
        //        //case "S360c":
        //        //    zsize = "_c360";
        //        //    break;
        //        //case "S640":
        //        //    zsize = "_640";
        //        //    break;
        //        //case "S640h":
        //        //    zsize = "_a640";
        //        //    break;
        //        //case "S640w":
        //        //    zsize = "_b640";
        //        //    break;
        //        //case "S640c":
        //        //    zsize = "_c640";
        //        //    break;
        //        //default:
        //        //    break;
        //}

        var imgs = new Array("img1", "img2", "img3", "img4");
        //这步不要删除 这是我算的协调世界时 (UTC) 公元 (C.E.) 1601 年 1 月 1 日午夜 12:00 的时间戳
        var tem = parseInt(11644473600);
        //这是最终的文件时间
        //var date = new Date((parseInt(temfilename) - tem) * 1000).toLocaleString().replace(/年|月/g, "/").replace(/日/g, " ").substring(0, 10);
        var date = new Date((parseInt(temfilename) - tem) * 1000).format('pubfile/yyyy/M/d/h/m');
        //这是拼接的最终地址  
        var resultrul = "";
        if (!zsize) {
            resultrul = 'http://' + imgs[parseInt(temfilename) % 4] + '.365zhiding.com/' + date + '/' + temfilename1 + ext;
        } else {
            resultrul = 'http://' + imgs[parseInt(temfilename) % 4] + '.365zhiding.com/' + date + '/' + temfilename1 + ext + zsize;
        }
        return resultrul;
    } catch (e) {
        return "";
    }
}