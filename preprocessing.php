<?php
function preproses($teks) {
     $teks = strtolower(trim($teks));
     
    //hilangkan tanda baca
    $teks = str_replace("'", " ", $teks);
 
    $teks = str_replace("-", " ", $teks);
 
    $teks = str_replace(")", " ", $teks);
 
    $teks = str_replace("(", " ", $teks);
 
    $teks = str_replace("\"", " ", $teks);
 
    $teks = str_replace("/", " ", $teks);
 
    $teks = str_replace("=", " ", $teks);
 
    $teks = str_replace(".", " ", $teks);
 
    $teks = str_replace(",", " ", $teks);
 
    $teks = str_replace(":", " ", $teks);
 
    $teks = str_replace(";", " ", $teks);
 
    $teks = str_replace("!", " ", $teks);
 
    $teks = str_replace("?", " ", $teks);
                 
    //2. hapus stoplist
    //daftar stop word diletakkan di array
    $astoplist = array("i ", "me ", "my ", "myself ", "we ", "our ", "ours ", "ourselves ", 
    "you ", "your ", "yours ", "yourself ", "yourselves ", "he ", "him ", "his ", "himself ", "she ", 
    "her ", "hers ", "herself ", "it ", "its ", "itself ", "they ", "them ", "their ", "theirs ", "themselves ",
    "what ", "which ", "who ", "whom ", "this ", "that ", "these ", "those ", "am ", "is ", "are ", "was ", "were",
    "be", "been", "being", "have", "has", "had", "having", "do", "does", "did", "doing", "a", "an", "the",
    "and", "but", "if", "or", "because", "as", "until", "while", "of", "at", "by", "for", "with", "about",
    "against", "between", "into", "through", "during", "before", "after", "above", "below", "to", "from", "up",
    "down", "in", "out", "on", "off", "over", "under", "again", "further", "then", "once", "here", "there", "when",
    "where", "why", "how", "all", "any", "both", "each", "few", "more", "most", "other", "some", "such", "no", "nor",
    "not", "only", "own", "same", "so", "than", "too", "very", "s", "t", "can", "will", "just", "don", "should", "now");     
                                             
    
    $teks = preg_replace('/\b('.implode('|',$astoplist).')\b/','',$teks);
    
             
    //3. terapkan stemming
    //pemetaan term --> stem hanya menggunakan array
    //index ganjil menunjukkan term dan index genap adalah stem dari term tersebut
    //anda boleh menggunakan database sebagai gantinya
    $astemlist = array("pertemuan", "temu", "bertemu", "temu", "cr9", "cristiano ronaldo", "berharap", "harap");
     
    //perhatikan cara mengubah suatu term ke bentuk stemnya
    for ($i=0; $i<count($astemlist); $i = $i +2) {
        //ganti term (jika ditemukan term pada index ganjil) dengan stem pada index genap ($i=1)        
        $teks = str_replace($astemlist[$i], $astemlist[$i+1], $teks);
    }

    return $teks;
 
}
 