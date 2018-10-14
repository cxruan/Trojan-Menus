from urllib import request
from bs4 import BeautifulSoup
import json

with request.urlopen('https://hospitality.usc.edu/residential-dining-menus/') as menus:
    data = menus.read()

    # print status of request in console
    print('Status:', menus.status, menus.reason)
    for k, v in menus.getheaders():
        print('%s: %s' % (k, v))
    
    # # print html in console
    # print("--------" + '\n')
    # print('Data:', data.decode('utf-8'))]

    # # write output in output.txt file
    # with open("output.txt", "w") as newFile:
    #     newFile.write('Status: 0' + str(menus.status) + ' ' + str(menus.reason) + '\n')
    #     for k, v in menus.getheaders():
    #         newFile.write(str(k) + ': ' + str(v)+ '\n')
    #     newFile.write('----------' + '\n')
    #     newFile.write(data.decode('utf-8'))

soup = BeautifulSoup(data.decode('utf-8'),'html.parser')

# search for separate html category
meals = soup.find_all(class_="hsp-accordian-container")
diningHalls = []
bars = []
for i_meal in range(len(meals)):
    diningHalls.append(meals[i_meal].find_all(class_="col-sm-6 col-md-4"))
    bars.append([])
    for i_diningHall in range(len(diningHalls[i_meal])):
        if diningHalls[i_meal][i_diningHall].find(class_="menu-item-list"):
            bars[i_meal].append(diningHalls[i_meal][i_diningHall].find_all(class_="menu-item-list"))
        else:
            bars[i_meal].append([])

# # write the filtered html in filtered.txt [DEBUG]
# with open("filtered.txt", "w") as newFile:
#     for meal in meals:
#         newFile.write(str(meal) + '\n')
#         for diningHall in diningHalls[meals.index(meal)]:
#             newFile.write('\t' + str(diningHall) + '\n')
#             if (len(bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]) != 0):
#                 for bar in bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]:
#                     newFile.write('\t\t' + str(bar) + '\n')
#             else:
#                 newFile.write('\t\t' + 'Null' + '\n')

# search for separate html tags
dishes = []
for meal in meals:
    dishes.append([])
    for diningHall in diningHalls[meals.index(meal)]:
        dishes[meals.index(meal)].append([])
        if (len(bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]) != 0):
            for bar in bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]:
                dishes[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].append([])
                for dish in bar.find_all("li"):
                    dishes[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)][bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].index(bar)].append(dish) 
        else:
            dishes[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].append("Null")

# write the filtered menu in filtered.txt
with open("filtered.txt", "w") as newFile:
    for meal in meals:
        newFile.write(meal.find(class_="fw-accordion-title-inner").get_text().split()[0] + '\n')
        for diningHall in diningHalls[meals.index(meal)]:
            newFile.write('\t' + diningHall.find(class_="menu-venue-title").get_text() + '\n')
            if (len(bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]) != 0):
                bars_ = diningHall.find_all("h4")
                for bar in bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]:
                    newFile.write('\t\t' + bars_[bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].index(bar)].get_text() + '\n')
                    for dish in dishes[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)][bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].index(bar)]:
                        newFile.write('\t\t\t' + dish.get_text() + '\n')
            else:
                newFile.write('\t\t' + 'Null' + '\n')