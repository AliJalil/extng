/*********************************************************************
 * @function      : tafqeet(Number, ISO_code, [{options}])
 * @purpose       : Converts Currency Values to Full Arabic Words
 * @version       : 2.00
 * @author        : Mohsen Alyafei
 * @date          : 04 March 2022
 * @Licence       : MIT
 * @param         : {Number} Numeric (required)
 * @param         : {code} 3-letter ISO Currency Code
 * @param         : [{options}] 3 Options passed as object {name:value} as follows:
 *                  {comma:'on'}      : Insert comma between triplet words.
 *                  {legal: 'on'}     : Uses legal mode
 *                  {format: 'short'} : Uses fractions for any decimal part.
 * @returns       : {string} The wordified number string in Arabic.
 *
 **********************************************************************/
function tafqeet(numIn = 0, code, op = {}) {
    let iso = tafqeetISOList[code];
    if (!iso) throw new Error( "Currency code not in the list!" );
    let arr = (numIn += "").split( (0.1).toLocaleString().substring( 1, 2 ) ),
        out = nToW( arr[0], iso.uGender == "female", op, [iso.uSingle, iso.uDouble, iso.uPlural] ),
        frc = arr[1] ? (arr[1] + "000").substring( 0, iso.fraction ) : 0;
    if (frc != 0) {
        out += "، و" + (op.format == "short" ? frc + "/1" + "0".repeat( +iso.fraction ) + " " + iso.uSingle :
            nToW( frc, iso.sGender == "female", op, [iso.sSingle, iso.sDouble, iso.sPlural] ));
    }
    return out;

    function nToW(numIn = 0, fm, {comma, legal} = {}, names) {
        if (numIn == 0) return "صفر " + iso.uSingle;
        let tS = [, "ألف", "مليون", "مليار", "ترليون", "كوادرليون", "كوينتليون", "سكستليون"],
            tM = ["", "واحد", "اثنان", "ثلاثة", "أربعة", "خمسة", "ستة", "سبعة", "ثمانية", "تسعة", "عشرة"],
            tF = ["", "واحدة", "اثنتان", "ثلاث", "أربع", "خمس", "ست", "سبع", "ثمان", "تسع", "عشر"],
            num = (numIn += ""), tU = [...tM], t11 = [...tM], out = "", n99, SpWa = " و", miah = "مائة",
            last = ~~(((numIn = "0".repeat( numIn.length * 2 % 3 ) + numIn).replace( /0+$/g, "" ).length + 2) / 3) - 1;
        t11[0] = "عشر";
        t11[1] = "أحد";
        t11[2] = "اثنا";
        numIn.match( /.{3}/g ).forEach( (n, i) => +n && (out += do999( numIn.length / 3 - i - 1, n, i == last ), i !== last && (out += (comma == 'on' ? "،" : "") + SpWa)) );
        let sub = " " + names[0], n = +(num + "").slice( -2 );
        if (n > 10) sub = " " + tanween( names[0] ); else if (n > 2) sub = " " + names[2];
        else if (n > 0) sub = names[n - 1] + " " + (fm ? tF[n] : tM[n]);
        return out + sub;

        function tanween(n, a = n.split` `, L = a.length - 1) {
            const strTF = (str, l = str.slice( -1 ), o = str + "ًا") => {
                return "ا" == l ? o = str.slice( 0, -1 ) + "ًا" : "ة" == l && (o = str + "ً"), o;
            };
            for (let i = 0; i <= L; i++) if (!i || i == L) a[i] = strTF( a[i] );
            return a.join` `;
        }

        function do999(sPos, num, last) {
            let scale = tS[sPos], n100 = ~~(num / 100), nU = (n99 = num % 100) % 10, n10 = ~~(n99 / 10), w100 = "",
                w99 = "", e8 = (nU == 8 && fm && !scale) ? "ي" : "";
            if (fm && !scale) {
                [tU, t11, t11[0], t11[1], t11[2]] = [[...tF], [...tF], "عشرة", "إحدى", "اثنتا"];
                if (n99 > 20) tU[1] = "إحدى";
            }
            if (n100) {
                if (n100 > 2) w100 = tF[n100] + miah; else if (n100 == 1) w100 = miah; else w100 = miah.slice( 0, -1 ) + (!n99 || legal == "on" ? "تا" : "تان");
            }
            if (n99 > 19) w99 = tU[nU] + (nU ? SpWa : "") + (n10 == 2 ? "عشر" : tF[n10]) + "ون";
            else if (n99 > 10) w99 = t11[nU] + e8 + " " + t11[0]; else if (n99 > 2) w99 = tU[n99] + e8;
            let nW = w100 + (n100 && n99 ? SpWa : "") + w99;
            if (!scale) return nW;
            if (!n99) return nW + " " + scale;
            if (n99 > 2) return nW + " " + (n99 > 10 ? scale + (last ? "" : "ًا")
                : (sPos < 3 ? [, "آلاف", "ملايين"][sPos] : tS[sPos] + "ات"));
            nW = (n100 ? w100 + ((legal == "on" && n99 < 3) ? " " + scale : "") + SpWa : "") + scale;
            return (n99 == 1) ? nW : nW + (last ? "ا" : "ان");
        }
    }
}

//=====================================================================


//==================== Common ISO Currency List in Arabic ===============
let tafqeetISOList = {
    IQD: {
        uSingle: "دينار عراقي",
        uDouble: "ديناران عراقيان",
        uPlural: "دنانير عراقية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 3
    },
    USD: {
        uSingle: "دولار امريكي",
        uDouble: "دولاران امريكيان",
        uPlural: "دولارات امريكية",
        uGender: "male",
        sSingle: "سنت",
        sDouble: "سنتان",
        sPlural: "سنتات",
        sGender: "male",
        fraction: 2
    },
    IRR: {
        uSingle: "ريال ايراني",
        uDouble: "ريالان ايرانيان",
        uPlural: "ريالات ايرانية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    SAR: {
        uSingle: "ريال سعودي",
        uDouble: "ريالان سعوديان",
        uPlural: "ريالات سعودية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    BHD: {
        uSingle: "دينار بحريني",
        uDouble: "ديناران بحرينيين",
        uPlural: "دنانير بحرينية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    KWD: {
        uSingle: "دينار كويتي",
        uDouble: "ديناران كويتيان",
        uPlural: "دنانير كويتية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    OMR: {
        uSingle: "ريال عماني",
        uDouble: "ريالان عمانيان",
        uPlural: "ريالات عمانية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    QAR: {
        uSingle: "ريال قطري",
        uDouble: "ريالان قطريان",
        uPlural: "ريالات قطرية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    LBP: {
        uSingle: "ليرة لبنانية",
        uDouble: "ليرتان لبنانية",
        uPlural: "ليرات لبنانية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    GBP: {
        uSingle: "باوند إنكليزي",
        uDouble: "باوند إنكليزي",
        uPlural: "باوند إنكليزي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    GBPS: {
        uSingle: "باوند اسكتلندي",
        uDouble: "باوند اسكتلندي",
        uPlural: "باوند اسكتلندي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },

    EUR: {
        uSingle: "يورو",
        uDouble: "يورو",
        uPlural: "يورو",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    INR: {
        uSingle: "روبية هندية",
        uDouble: "روبيتان هنديتان",
        uPlural: "روبيات هندية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    PKR: {
        uSingle: "روبية باكستانية",
        uDouble: "روبيتان باكستانيتان",
        uPlural: "روبيات باكستانية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    AUD: {
        uSingle: "دولار استرالي",
        uDouble: "دولاران استراليان",
        uPlural: "دولارات استرالية",
        uGender: "male",
        sSingle: "سنت",
        sDouble: "سنتان",
        sPlural: "سنتات",
        sGender: "male",
        fraction: 2
    },
    CAD: {
        uSingle: "دولار كندي",
        uDouble: "دولاران كنديان",
        uPlural: "دولارات كندية",
        uGender: "male",
        sSingle: "سنت",
        sDouble: "سنتان",
        sPlural: "سنتات",
        sGender: "male",
        fraction: 2
    },
    JOD: {
        uSingle: "دينار اردني",
        uDouble: "ديناران اردنيان",
        uPlural: "دنانير اردنية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    AFN: {
        uSingle: "افغاني",
        uDouble: "افغانيان",
        uPlural: "افغاني",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    AED: {
        uSingle: "درهم إماراتي",
        uDouble: "درهمان إماراتيان",
        uPlural: "دراهم إماراتية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    IDR: {
        uSingle: "روبية اندنوسية",
        uDouble: "روبيتان اندنوسيتان",
        uPlural: "روبيات اندنوسية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    BDT: {
        uSingle: "تاكا بنغلاديشي ",
        uDouble: "اثنان تاكا بنغلاديشي",
        uPlural: "تاكا بنغلاديشي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    THB: {
        uSingle: "بات تايلندي",
        uDouble: "اثنان بات تايلندي",
        uPlural: "بات تايلندي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    EGP: {
        uSingle: "جنيه مصري",
        uDouble: "اثنان جنيه مصري",
        uPlural: "جنيهات مصرية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    SGD: {
        uSingle: "دولار سنغافوري",
        uDouble: "دولاران سنغافوري",
        uPlural: "دولارات سنغافورية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    HKD: {
        uSingle: "دولار هونغ كونغ",
        uDouble: "دولاران هونغ كونغ",
        uPlural: "دولارات هونغ كونغ",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    ZAR: {
        uSingle: "راند جنوب افريقي",
        uDouble: "اثنان راند جنوب افريقي",
        uPlural: "راند جنوب افريقي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    RUB: {
        uSingle: "روبل روسي",
        uDouble: "اثنان روبل روسي",
        uPlural: "روبل روسي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    BRL: {
        uSingle: "ريال برازيلي",
        uDouble: "اثنان ريال برازيلي",
        uPlural: "ريال برازيلي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    KES: {
        uSingle: "شيلنغ كيني",
        uDouble: "اثنان شيلنغ كيني",
        uPlural: "شيلنغ كيني",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    CHF: {
        uSingle: "فرنك سويسري",
        uDouble: "اثنان فرنك سويسري",
        uPlural: "فرنك سويسري",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    DKK: {
        uSingle: "كرونة دنماركية",
        uDouble: "اثنان كرونة دنماركية",
        uPlural: "كرونة دنماركية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    SEK: {
        uSingle: "كرونة سويدية",
        uDouble: "اثنان كرونة سويدية",
        uPlural: "كرونة سويدية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    TRY: {
        uSingle: "ليرة تركية",
        uDouble: "ليرتان تركيتان",
        uPlural: "ليرات تركية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    LYP: {
        uSingle: "ليرة سورية",
        uDouble: "ليرتان سوريتان",
        uPlural: "ليرات سورية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    MYR: {
        uSingle: "رينغيت ماليزي",
        uDouble: "اثنان رينغيت ماليزي",
        uPlural: "رينغيت ماليزي",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    AZN: {
        uSingle: "مانات اذربيجاني",
        uDouble: "اثنان مانات اذربيجاني",
        uPlural: "مانات اذربيجاني",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    NOK: {
        uSingle: "كرونة نرويجية",
        uDouble: "اثنان كرونة نرويجية",
        uPlural: "كرونة نرويجية",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    NZD: {
        uSingle: "دولار نيوزلندي",
        uDouble: "دولاران نيوزلنديان",
        uPlural: "دولارات نيوزلندية",
        uGender: "male",
        sSingle: "سنت",
        sDouble: "سنتان",
        sPlural: "سنتات",
        sGender: "male",
        fraction: 2
    },
    KRW: {
        uSingle: "وان كوري",
        uDouble: "اثنان وان كوري",
        uPlural: "وان كوري",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    JPY: {
        uSingle: "ين ياباني",
        uDouble: "اثنان ين ياباني",
        uPlural: "ين ياباني",
        uGender: "male",
        sSingle: "فلس",
        sDouble: "فلسان",
        sPlural: "فلوس",
        sGender: "male",
        fraction: 2
    },
    WEIGHT: {
        uSingle: "غرام", uDouble: "غرامان", uPlural: "غرامات", uGender: "male",
        sSingle: "سنت", sDouble: "سنتان", sPlural: "سنتات", sGender: "male", fraction: 3
    },
    PURE: {
        uSingle: "", uDouble: "", uPlural: "", uGender: "male",
        sSingle: "", sDouble: "", sPlural: "", sGender: "male", fraction: 2
    },

}; // end of list

