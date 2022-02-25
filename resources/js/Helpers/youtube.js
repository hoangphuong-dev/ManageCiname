export const getYoutubeId = (item) => {
    var regExp =
        /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    var match = item?.trailler.match(regExp);
    return match && match[7].length == 11 ? match[7] : false;
}
