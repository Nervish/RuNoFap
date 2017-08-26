#!/bin/bash

style_dir='styles/real'
style_target='apps/nf_r34/view-universal'
style_savepath='apps/nf_r34/res/style'

tdir=$(mktemp -d)

for i in $(find $style_target -type f);do
    file=$(basename $i|sed "s/\.php/.css/g")
    echo "$style_savepath/$file:"
    echo -n '' > $style_savepath/$file
    for j in $(grep -i -o -E 'class="[^"]*"' $i|sed "s/class=//g"|tr -d '"'|sort|uniq);do
        touch "$tdir/$j"
    done
    for j in $(find $tdir -type f|sort);do
        class=$(basename $j)
        for k in $(find $style_dir -type f -name "$class.css");do
            cat $k|tr '\n' ' '|sed "s/[ ]+/ /g" >> $style_savepath/$file
            echo " +  $class"
        done
    done
    #for j in $(find $tdir -type f);do
    #    class=$(basename $j)
    #    if [[ -f $style_dir/$class.css ]];then
    #        cat $style_dir/$class.css|tr '\n' ' '|sed "s/[ ]+/ /g" >> $style_savepath/$file
    #        echo " +  $class"
    #    fi
    #done
    rm -f $tdir/*
    echo
done
