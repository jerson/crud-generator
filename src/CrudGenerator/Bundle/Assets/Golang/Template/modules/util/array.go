// Package util ...
package util

import (
	"fmt"
	"github.com/emirpasic/gods/sets/hashset"
	"strings"
)

// SliceUniqueString ...
func SliceUniqueString(items string) string {
	list := strings.Split(items, ",")
	return strings.Join(SliceUnique(list), ",")
}

// SliceUnique ...
func SliceUnique(list []string) []string {

	var newItems []string
	itemsSet := hashset.New()

	for _, id := range list {
		if id != "" {
			itemsSet.Add(id)
		}
	}
	values := itemsSet.Values()
	for _, item := range values {
		newItems = append(newItems, item.(string))
	}
	return newItems
}

// SliceContains ...
func SliceContains(text string, list []string) bool {
	for _, b := range list {
		if b == text {
			return true
		}
	}
	return false
}

// SliceKeys ...
func SliceKeys(data map[string]string) []string {
	var keys []string
	for k := range data {
		keys = append(keys, k)
	}
	return keys
}

// SortValues ...
func SortValues(sort, sortType string, sortAllows map[string]string) string {

	sortTypeAllows := []string{"asc", "desc"}

	if SliceContains(sort, SliceKeys(sortAllows)) {
		sort = sortAllows[sort]
	} else {
		sort = ""
	}
	if !SliceContains(sortType, sortTypeAllows) {
		sortType = "asc"
	}

	sortString := ""
	if sort != "" {
		sortString = fmt.Sprintf("%s %s", sort, sortType)
	}
	return sortString
}
