#! /bin/bash

function they_are_friends() {
    declare -A name_age_pairs
    name_age_pairs=(
        [iton]=23
        [xiangzi]=25
    )

    local name_age_string=
    for name_age_pair in "${!name_age_pairs[@]}"
    do
      name_age_string="$name_age_string --one_person name:$name_age_pair=age:${name_age_pairs[$name_age_pair]}"
    done
    name_string=$(echo "${!name_age_pairs[@]}" | tr '_' '-')
    name_age_string="$name_age_string. Remember, $name_string, they are good friends."
    echo "$name_age_string"
}

they_are_friends

# output :
# --one_person name:iton=age:23 --one_person name:xiangzi=age:25. iton xiangzi:they are good friends.
