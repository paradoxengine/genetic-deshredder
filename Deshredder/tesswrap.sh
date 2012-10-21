#!/bin/bash
# ###############################################################################
#
#                                       ocube
#
#                          *** tesseract made simple ***
#
# ###############################################################################
#
# ocube is a tesseract wrapper to preprocess pictures for OCR
#

# defaults
# all variables are overwritten with the respective option!
TIFF=TRUE            # delete tif images after use
TESS=TRUE            # delete tesseract data after use
TIFFDIR=/tmp/            # folder for tiff images
TESSDIR=/tmp/            # folder for tesseract data
SILENT=                # if TRUE no output on STDOUT or STDERR
CONV=TRUE              # TRUE=convert extentsively
ERRORLOG=""            # errorlog, if ! empty error messages go there otherwise STDERR
EX_FILE=            # exclude files found in EX_FILE
FILE=""                # if FILE *not* empty, scanned text (i.e. result) goes to FILE

# execute .conf file, if file exists
if [[ -f /etc/ocube.conf ]]
then
    . /etc/ocube.conf
fi

if [[ -z "$1"  ]]
    then
    echo "Usage: $0 [OPTIONS]  file1 file2 ...

    converts files to tif, scans them with tesseract and outputs the text on STDOUT 
   
    OPTIONS:
        -t TIF-DIR    saves converted TIF images in target-directory TIF-DIR
        -o TESS-DIR    saves files created by tesseract in TESS-DIR
        -i <FILE>    define input file (otherwise STDIN)
        -f FILE        saves all text output in file FILE  (messages on STDOUT)
        -s         silent; no output on STDOUT
        -c        convert with fill white, resize, sigmoidal-contrast, etc..
        -l        save error messages in ocube.error.log instead of showing them on STDERR
        -L <file>    save error messages in <file>
        -e         exclude files found in ocube.error.log. Avoids rescaning of files
                that were processed already.
        -E <file>    same as -e but with file <file>
   
    By default, everything (progress-, error-messages and output) will be shown on STDOUT.
    Read ocube.info for more information

    Scanning takes time... be patient :)
   
"
    exit
fi

# get options...
while getopts ":t:o:i:f:sclL:eE:" Option
    do
    case $Option in
        t )    # save converted tif files in directory
            TIFFDIR="$OPTARG"/
            TESS=FALSE
      ;;
        o )    # save tesseract files in directory
                        TESSDIR="$OPTARG"/
            TIFF=FALSE
      ;;
        i)    # input file
            SCANS="$OPTARG"
      ;;
        f )    # save output in file instead STDOUT; me
            FILE="$OPTARG"
      ;;
        s )    # silent
            SILENT=TRUE
      ;;
        c )    # convert picture extensively
            CONV=TRUE
      ;;
        l)    # save error messages in ocube.error.log
            ERRORLOG="ocube.error.log"
      ;;
        L)    # save error messages in <file>
            ERRORLOG="$OPTARG"
      ;;
        e )    # exclude files in tes.error.log
            EX_FILE="ocube.error.log"
      ;;
        E)    # exclude files in <file>
            EX_FILE="$OPTARG"
      ;;
    esac
done
shift $(($OPTIND - 1))

# redirections ...
# if SILENT is set, redirect everything to /dev/null
if [[ $SILENT == TRUE ]]
then
    exec 2>&1 1>/dev/null
fi
# if FILE (-f) is set, redirect output to FILE
[[ -z $FILE ]] || exec 1>>$FILE
# if ERRORLOG (-L|-l) is set, redirect STDERR to ERRORLOG
[[ -z $ERRORLOG ]] || exec 2>>$ERRORLOG

# check for file's existance
# check, if exclusion-file exists but only when activated, i.e. not empty
if [[ ! -z "$EX_FILE" && ! -f "$EX_FILE" ]]; then
    echo "-E/-e: $EX_FILE: no such file" >&2
    exit
fi
# check, if tesseract-folder exists
if [[ ! -d "$TESSDIR" ]]; then
     echo "-o: $TESSDIR: no such folder" >&2
     exit
fi
# check, if tif-folder exists
if [[ ! -d "$TIFFDIR" ]]; then
    echo "-t: $TIFFDIR: no such folder" >&2
    exit
fi


echo "TIF-output directory=$TIFFDIR" >&2
echo "tesseract output directory=$TESSDIR" >&2

# if there is no specificially mentioned input file (-i) use STDIN
[[ -z "$SCANS" ]] && SCANS="$*"

# exit if no input files present with error message
if [[ -z "$SCANS" ]];then
    echo "No input file, aborting!"  >&2
    exit
fi

for i in $SCANS
    do
        # -e/E: check exclusion file list
        if [[ ! -z "$EX_FILE" ]]; then
            if grep -q "$i" "$EX_FILE"
            then
            continue
        fi; fi
        I_FILE=${i##*/}        #just the filename w/o directory
        # check if file exists
        if [[ ! -f "$i" ]]       
            then
            echo "$i: file not found" >&2
            continue
        fi
        # check if graphics file can be converted
        if ! identify "$i" 1>&2   
            then
            echo "$i: not convertable" >&2
            continue
        fi
        # file ok, let's start
        echo "processeing: $i ..." >&2
       
        NEWTIF="$TIFFDIR""${I_FILE%.*}".tif
        T_FILE="$TESSDIR""${I_FILE%\.*}"
        # converting the graphic file
        if [[ $CONV == "TRUE" ]]
        then        # convert with additional processing
            convert "$i" -density 150x150 -resize 200% -fill white -tint 50 -level 20%,80%,1.0 -sigmoidal-contrast 30,50% -sharpen 0x2 -compress none -monochrome "$NEWTIF" 1>&2
        else        # convert simply (better for line art)
            convert "$i" -density 150x150 -compress none  "$NEWTIF" 1>&2
        fi
        # scanning the newly created tif
#        tesseract "$NEWTIF" "$T_FILE" 1>&2
#TESSERACT VALUES
        tesseract "$NEWTIF" "$T_FILE" nobatch ./deshredder_tesseract_conf  1>&2
        #  output scanned text
        cat "$T_FILE".txt
        #  delete graphic file after use, if not unset in option
        if [[ $TESS == "TRUE" ]]
                        then
                        rm "$NEWTIF"
                fi
        # delete tesseract output   
        if [[ $TIFF == "TRUE" ]]
                        then
                        rm "$T_FILE".map "$T_FILE".raw "$T_FILE".txt
                fi   
done
