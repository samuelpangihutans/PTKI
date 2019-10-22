<?php
    include 'vendor/autoload.php';
    
    use Skyeng\Lemmatizer;

    // Require Composer's autoloader
    require_once __DIR__ . "/vendor/autoload.php";

    class Preprocessing{
        private $stop_words;
        private $stemming_list;
        private $lemmatizer;
        public function __construct(){ 
            $this->stop_words=array
            ("i", "me", "my", "myself", "we", "our", "ours", "ourselves", "you", "your", "yours", "yourself", "yourselves", 
            "he", "him", "his", "himself", "she", "her", "hers", "herself", "it", "its", "itself",  "they", "them", "their", 
            "theirs", "themselves", "what", "which", "who", "whom", "this", "that", "these", "those", "am", "is", "are", "was", 
            "were", "be", "been", "being", "have", "has", "had", "having", "do", "does", "did", "doing", "a", "an", "the", "and", 
            "but", "if", "or", "because", "as", "until", "while", "of", "at", "by", "for", "with", "about", "against", "between", 
            "into", "through", "during", "before", "after", "above", "below", "to", "from", "up", "down", "in",  "out", "on", "off", 
            "over", "under", "again", "further", "then", "once", "here", "there", "when", "where", "why", "how",  "all", "any", "both", 
            "each", "few", "more", "most", "other", "some", "such", "no", "nor", "not", "only", "own", "same",  "so", "than", "too", 
            "very", "s", "t", "can", "will", "just", "don", "should", "now");
        
            $this->lemmatizer = new Lemmatizer();
        }
        
        private function lowerCases($teks){
            return strtolower(trim($teks));
        }

        private function removePunctuation($teks){
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
            $teks = preg_replace('/\s+/', ' ', $teks);
            $teks = str_replace("\n","",$teks);
            return $teks;
        }

        private function removeStopWords($teks){
            return preg_replace('/\b('.implode('|',$this->stop_words).')\b/','',$teks);
        }

        private function stemming($teks){
            return \Nadar\Stemming\Stemm::stemPhrase($teks, 'en');
        }

        private function lemmatization($teks){
            $str = explode(" ",$teks);
            $result = "";
            foreach($str as $s){
                $lemmas = $this->lemmatizer->getLemmas($s);
                $result .= $lemmas[0]->getLemma()." ";
            }
            return $result;
        }

        public function doPreprocessing($teks){
            $result = $this->lowerCases($teks);
            $result = $this->lemmatization($result);
            $result = $this->removeStopWords($result);
            $result = $this->removePunctuation($result);
            $result = $this->stemming($result);
            $result = ltrim($result);
            return $result;
        }
    }
?>