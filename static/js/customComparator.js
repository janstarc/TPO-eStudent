/**
 *  Implementacija compare funkcije za slovenščino
 */

function sloValue(char){
    "use strict";
    var key = char.toLocaleLowerCase();
    var tabela = {
        0:0,
        1:1,
        2:2,
        3:3,
        4:4,
        5:5,
        6:6,
        7:7,
        8:8,
        9:9,
        a:10,
        b:11,
        c:12,
        č:13,
        d:14,
        e:15,
        f:16,
        g:17,
        h:18,
        i:19,
        j:21,
        k:22,
        l:23,
        m:24,
        n:25,
        o:26,
        p:27,
        q:28,
        r:29,
        s:30,
        š:31,
        t:32,
        u:33,
        v:34,
        w:35,
        x:36,
        y:37,
        z:38,
        ž:39
    }

    if(typeof tabela[key] === 'undefined') return 40;      // Ce je poslana kaka cudna vrednost, npr. .,*+

    return tabela[key];
}

/** HOW TO USE? Kakšna je pozicija b1 glede na b2? --> Pozicija b2 se vzame kot FIKSNA
 Ce je return value -1 --> Beseda b1 je NAD besedo b2
 Ce je return value 0  --> Beseda b1 je ENAKA kot beseda b2
 Ce je return value 1  --> Beseda b1 je POD besedo b2

 sloCompare(abc, abcd) = -1 --> abc je NAD abcd
 sloCompare(abc, abc)  = 0  --> Besedi sta enaki
 sloCompare(abcd, abc) = 1  --> abcd je POD abc
 */
function sloCompare(b1, b2){
    "use strict";
    var shorterLen;
    if(b1.length <= b2.length){
        shorterLen = b1.length;
    } else {
        shorterLen = b2.length;
    }

    var i = 0;
    while(i < shorterLen){
        if(sloValue(b1[i]) > sloValue(b2[i])) return 1;
        else if (sloValue(b1[i]) < sloValue(b2[i])) return -1;
        i++;
    }

    if(b1.length === b2.length)  return 0;          // Enaki
    if(b1.length === shorterLen) return -1;         // Primer b1=abc, b2=abcd
    if(b2.length === shorterLen) return 1;          // Primer b1=abcd, b1=abc
}